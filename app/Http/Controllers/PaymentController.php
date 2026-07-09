<?php
namespace App\Http\Controllers;
use App\Models\{Payment, PatientBill, Patient};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['patient', 'patientBill']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('method')) $query->where('method', $request->method);
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('payments.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $bills = PatientBill::where('status', 'unpaid')->orWhere('status', 'partial')->get();
        return view('payments.create', compact('patients', 'bills'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_bill_id' => 'required|exists:patient_bills,id',
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'received_by' => 'nullable|exists:users,id',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = Payment::whereDate('created_at', today())->count();
            $validated['payment_number'] = 'PAY-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['payment_date'] = $validated['payment_date'] ?? now();
            Payment::create($validated);
            DB::commit();
            return redirect()->route('payments.index')->with('success', 'Data pembayaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = Payment::with(['patient', 'patientBill', 'receiver'])->findOrFail($id); return view('payments.show', compact('item')); }
    public function edit($id)
    {
        $item = Payment::findOrFail($id);
        $patients = Patient::all();
        $bills = PatientBill::all();
        return view('payments.edit', compact('item', 'patients', 'bills'));
    }
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $validated = $request->validate([
            'patient_bill_id' => 'required|exists:patient_bills,id',
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'received_by' => 'nullable|exists:users,id',
        ]);
        $payment->update($validated);
        return redirect()->route('payments.index')->with('success', 'Data pembayaran berhasil diupdate');
    }
    public function destroy($id) { Payment::findOrFail($id)->delete(); return redirect()->route('payments.index')->with('success', 'Data pembayaran berhasil dihapus'); }
}
