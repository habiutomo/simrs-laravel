<?php
namespace App\Http\Controllers;
use App\Models\{LabRequest, Patient, Doctor, LabTest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LabRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LabRequest::with(['patient', 'doctor', 'labTest']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('priority')) $query->where('priority', $request->priority);
        $items = $query->latest()->paginate(10);
        return view('lab-requests.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $labTests = LabTest::where('is_active', true)->get();
        return view('lab-requests.create', compact('patients', 'doctors', 'labTests'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'lab_test_id' => 'required|exists:lab_tests,id',
            'labrequestable_type' => 'nullable|string|max:255',
            'labrequestable_id' => 'nullable|integer',
            'priority' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'requested_at' => 'nullable|date',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = LabRequest::whereDate('created_at', today())->count();
            $validated['request_number'] = 'LAB-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['requested_at'] = $validated['requested_at'] ?? now();
            LabRequest::create($validated);
            DB::commit();
            return redirect()->route('lab-requests.index')->with('success', 'Data permintaan lab berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = LabRequest::with(['patient', 'doctor', 'labTest', 'results'])->findOrFail($id); return view('lab-requests.show', compact('item')); }
    public function edit($id)
    {
        $item = LabRequest::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $labTests = LabTest::where('is_active', true)->get();
        return view('lab-requests.edit', compact('item', 'patients', 'doctors', 'labTests'));
    }
    public function update(Request $request, $id)
    {
        $labRequest = LabRequest::findOrFail($id);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'lab_test_id' => 'required|exists:lab_tests,id',
            'labrequestable_type' => 'nullable|string|max:255',
            'labrequestable_id' => 'nullable|integer',
            'priority' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'requested_at' => 'nullable|date',
        ]);
        $labRequest->update($validated);
        return redirect()->route('lab-requests.index')->with('success', 'Data permintaan lab berhasil diupdate');
    }
    public function destroy($id) { LabRequest::findOrFail($id)->delete(); return redirect()->route('lab-requests.index')->with('success', 'Data permintaan lab berhasil dihapus'); }
}
