<?php
namespace App\Http\Controllers;
use App\Models\{OutpatientVisit, Registration, Patient, Doctor, Polyclinic};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class OutpatientVisitController extends Controller
{
    public function index(Request $request)
    {
        $query = OutpatientVisit::with(['patient', 'doctor', 'polyclinic']);
        if ($request->filled('polyclinic_id')) $query->where('polyclinic_id', $request->polyclinic_id);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date')) $query->whereDate('created_at', $request->date);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('outpatient-visits.index', compact('items', 'polyclinics'));
    }
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        $registrations = Registration::whereIn('type', ['rajal', 'outpatient'])->where('status', 'done')->get();
        return view('outpatient-visits.create', compact('patients', 'doctors', 'polyclinics', 'registrations'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'nullable|exists:registrations,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'status' => 'nullable|string|max:50',
            'queue_number' => 'nullable|string|max:20',
            'anamnesis' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'therapy' => 'nullable|string',
            'notes' => 'nullable|string',
            'check_in_at' => 'nullable|date',
            'check_out_at' => 'nullable|date',
        ]);
        DB::beginTransaction();
        try {
            if (empty($validated['queue_number'])) {
                $today = now()->format('Ymd');
                $count = OutpatientVisit::whereDate('created_at', today())->count();
                $validated['queue_number'] = 'Q-' . $today . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            }
            OutpatientVisit::create($validated);
            DB::commit();
            return redirect()->route('outpatient-visits.index')->with('success', 'Data kunjungan rawat jalan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = OutpatientVisit::with(['patient', 'doctor', 'polyclinic', 'registration'])->findOrFail($id); return view('outpatient-visits.show', compact('item')); }
    public function edit($id)
    {
        $item = OutpatientVisit::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        $registrations = Registration::whereIn('type', ['rajal', 'outpatient'])->get();
        return view('outpatient-visits.edit', compact('item', 'patients', 'doctors', 'polyclinics', 'registrations'));
    }
    public function update(Request $request, $id)
    {
        $visit = OutpatientVisit::findOrFail($id);
        $validated = $request->validate([
            'registration_id' => 'nullable|exists:registrations,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'status' => 'nullable|string|max:50',
            'queue_number' => 'nullable|string|max:20',
            'anamnesis' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'therapy' => 'nullable|string',
            'notes' => 'nullable|string',
            'check_in_at' => 'nullable|date',
            'check_out_at' => 'nullable|date',
        ]);
        $visit->update($validated);
        return redirect()->route('outpatient-visits.index')->with('success', 'Data kunjungan rawat jalan berhasil diupdate');
    }
    public function destroy($id) { OutpatientVisit::findOrFail($id)->delete(); return redirect()->route('outpatient-visits.index')->with('success', 'Data kunjungan rawat jalan berhasil dihapus'); }
}
