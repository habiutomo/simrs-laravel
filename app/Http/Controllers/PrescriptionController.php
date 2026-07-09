<?php
namespace App\Http\Controllers;
use App\Models\{Prescription, PrescriptionItem, Patient, Doctor, Medicine};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'doctor']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('prescriptions.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->where('stock', '>', 0)->get();
        return view('prescriptions.create', compact('patients', 'doctors', 'medicines'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'prescriptable_type' => 'nullable|string|max:255',
            'prescriptable_id' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'prescribed_at' => 'nullable|date',
            'items' => 'required|array',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.dosage' => 'nullable|string|max:100',
            'items.*.frequency' => 'nullable|string|max:100',
            'items.*.instruction' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.days' => 'nullable|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = Prescription::whereDate('created_at', today())->count();
            $validated['prescription_number'] = 'RX-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['prescribed_at'] = $validated['prescribed_at'] ?? now();
            $prescription = Prescription::create($validated);
            foreach ($validated['items'] as $item) {
                $prescription->items()->create($item);
            }
            DB::commit();
            return redirect()->route('prescriptions.index')->with('success', 'Data resep berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = Prescription::with(['patient', 'doctor', 'items.medicine'])->findOrFail($id); return view('prescriptions.show', compact('item')); }
    public function edit($id)
    {
        $item = Prescription::with('items')->findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->get();
        return view('prescriptions.edit', compact('item', 'patients', 'doctors', 'medicines'));
    }
    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'prescriptable_type' => 'nullable|string|max:255',
            'prescriptable_id' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'prescribed_at' => 'nullable|date',
            'items' => 'required|array',
            'items.*.id' => 'nullable|exists:prescription_items,id',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.dosage' => 'nullable|string|max:100',
            'items.*.frequency' => 'nullable|string|max:100',
            'items.*.instruction' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.days' => 'nullable|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $prescription->update(collect($validated)->except('items')->toArray());
            $existingIds = $prescription->items()->pluck('id')->toArray();
            $incomingIds = collect($validated['items'])->pluck('id')->filter()->toArray();
            $toDelete = array_diff($existingIds, $incomingIds);
            PrescriptionItem::whereIn('id', $toDelete)->delete();
            foreach ($validated['items'] as $item) {
                if (!empty($item['id'])) {
                    PrescriptionItem::findOrFail($item['id'])->update(collect($item)->except('id')->toArray());
                } else {
                    $prescription->items()->create(collect($item)->except('id')->toArray());
                }
            }
            DB::commit();
            return redirect()->route('prescriptions.index')->with('success', 'Data resep berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy($id) { Prescription::findOrFail($id)->delete(); return redirect()->route('prescriptions.index')->with('success', 'Data resep berhasil dihapus'); }
}
