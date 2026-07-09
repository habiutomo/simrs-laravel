<?php
namespace App\Http\Controllers;
use App\Models\{RadiologyRequest, Patient, Doctor, RadiologyTest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RadiologyRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = RadiologyRequest::with(['patient', 'doctor', 'radiologyTest']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('radiology-requests.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $radiologyTests = RadiologyTest::where('is_active', true)->get();
        return view('radiology-requests.create', compact('patients', 'doctors', 'radiologyTests'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'radiology_test_id' => 'required|exists:radiology_tests,id',
            'radrequestable_type' => 'nullable|string|max:255',
            'radrequestable_id' => 'nullable|integer',
            'priority' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'clinical_info' => 'nullable|string',
            'requested_at' => 'nullable|date',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = RadiologyRequest::whereDate('created_at', today())->count();
            $validated['request_number'] = 'RAD-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['requested_at'] = $validated['requested_at'] ?? now();
            RadiologyRequest::create($validated);
            DB::commit();
            return redirect()->route('radiology-requests.index')->with('success', 'Data permintaan radiologi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = RadiologyRequest::with(['patient', 'doctor', 'radiologyTest', 'result'])->findOrFail($id); return view('radiology-requests.show', compact('item')); }
    public function edit($id)
    {
        $item = RadiologyRequest::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $radiologyTests = RadiologyTest::where('is_active', true)->get();
        return view('radiology-requests.edit', compact('item', 'patients', 'doctors', 'radiologyTests'));
    }
    public function update(Request $request, $id)
    {
        $radiologyRequest = RadiologyRequest::findOrFail($id);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'radiology_test_id' => 'required|exists:radiology_tests,id',
            'radrequestable_type' => 'nullable|string|max:255',
            'radrequestable_id' => 'nullable|integer',
            'priority' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'clinical_info' => 'nullable|string',
            'requested_at' => 'nullable|date',
        ]);
        $radiologyRequest->update($validated);
        return redirect()->route('radiology-requests.index')->with('success', 'Data permintaan radiologi berhasil diupdate');
    }
    public function destroy($id) { RadiologyRequest::findOrFail($id)->delete(); return redirect()->route('radiology-requests.index')->with('success', 'Data permintaan radiologi berhasil dihapus'); }
}
