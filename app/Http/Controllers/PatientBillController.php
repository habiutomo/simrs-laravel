<?php
namespace App\Http\Controllers;
use App\Models\{PatientBill, BillItem, Patient, Registration, Insurance};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PatientBillController extends Controller
{
    public function index(Request $request)
    {
        $query = PatientBill::with(['patient', 'registration']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('patient-bills.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $registrations = Registration::all();
        $insurances = Insurance::where('is_active', true)->get();
        return view('patient-bills.create', compact('patients', 'registrations', 'insurances'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'registration_id' => 'nullable|exists:registrations,id',
            'insurance_id' => 'nullable|exists:insurances,id',
            'billable_type' => 'nullable|string|max:255',
            'billable_id' => 'nullable|integer',
            'subtotal' => 'nullable|numeric|min:0',
            'insurance_coverage' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.item_type' => 'nullable|string|max:100',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.notes' => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = PatientBill::whereDate('created_at', today())->count();
            $validated['bill_number'] = 'BILL-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $items = $validated['items'] ?? [];
            unset($validated['items']);
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            $validated['subtotal'] = $validated['subtotal'] ?? $subtotal;
            $discount = $validated['discount'] ?? 0;
            $insuranceCoverage = $validated['insurance_coverage'] ?? 0;
            $validated['total'] = $validated['total'] ?? ($subtotal - $discount - $insuranceCoverage);
            $bill = PatientBill::create($validated);
            foreach ($items as $item) {
                $item['subtotal'] = $item['quantity'] * $item['unit_price'];
                $bill->items()->create($item);
            }
            DB::commit();
            return redirect()->route('patient-bills.index')->with('success', 'Data tagihan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = PatientBill::with(['patient', 'registration', 'insurance', 'items', 'payments'])->findOrFail($id); return view('patient-bills.show', compact('item')); }
    public function edit($id)
    {
        $item = PatientBill::with('items')->findOrFail($id);
        $patients = Patient::all();
        $registrations = Registration::all();
        $insurances = Insurance::where('is_active', true)->get();
        return view('patient-bills.edit', compact('item', 'patients', 'registrations', 'insurances'));
    }
    public function update(Request $request, $id)
    {
        $bill = PatientBill::findOrFail($id);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'registration_id' => 'nullable|exists:registrations,id',
            'insurance_id' => 'nullable|exists:insurances,id',
            'billable_type' => 'nullable|string|max:255',
            'billable_id' => 'nullable|integer',
            'subtotal' => 'nullable|numeric|min:0',
            'insurance_coverage' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:bill_items,id',
            'items.*.item_type' => 'nullable|string|max:100',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.notes' => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $items = $validated['items'] ?? [];
            unset($validated['items']);
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            $validated['subtotal'] = $validated['subtotal'] ?? $subtotal;
            $discount = $validated['discount'] ?? 0;
            $insuranceCoverage = $validated['insurance_coverage'] ?? 0;
            $validated['total'] = $validated['total'] ?? ($subtotal - $discount - $insuranceCoverage);
            $bill->update($validated);
            $existingIds = $bill->items()->pluck('id')->toArray();
            $incomingIds = collect($items)->pluck('id')->filter()->toArray();
            $toDelete = array_diff($existingIds, $incomingIds);
            BillItem::whereIn('id', $toDelete)->delete();
            foreach ($items as $item) {
                $itemData = $item;
                $itemData['subtotal'] = $item['quantity'] * $item['unit_price'];
                if (!empty($item['id'])) {
                    BillItem::findOrFail($item['id'])->update(collect($itemData)->except('id')->toArray());
                } else {
                    $bill->items()->create(collect($itemData)->except('id')->toArray());
                }
            }
            DB::commit();
            return redirect()->route('patient-bills.index')->with('success', 'Data tagihan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy($id) { PatientBill::findOrFail($id)->delete(); return redirect()->route('patient-bills.index')->with('success', 'Data tagihan berhasil dihapus'); }
}
