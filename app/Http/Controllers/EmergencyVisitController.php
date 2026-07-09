<?php
namespace App\Http\Controllers;
use App\Models\{EmergencyVisit, Registration, Patient, Doctor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmergencyVisitController extends Controller
{
    public function index(Request $request)
    {
        $query = EmergencyVisit::with(['patient', 'doctor']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('triage')) $query->where('triage', $request->triage);
        $items = $query->latest()->paginate(10);
        return view('emergency-visits.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $registrations = Registration::where('type', 'igd')->get();
        return view('emergency-visits.create', compact('patients', 'doctors', 'registrations'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'nullable|exists:registrations,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'triage' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'complaint' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'disposition' => 'nullable|string',
            'arrival_time' => 'nullable|date',
            'discharge_time' => 'nullable|date',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = EmergencyVisit::whereDate('created_at', today())->count();
            $validated['emergency_number'] = 'IGD-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['arrival_time'] = $validated['arrival_time'] ?? now();
            EmergencyVisit::create($validated);
            DB::commit();
            return redirect()->route('emergency-visits.index')->with('success', 'Data kunjungan IGD berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = EmergencyVisit::with(['patient', 'doctor'])->findOrFail($id); return view('emergency-visits.show', compact('item')); }
    public function edit($id)
    {
        $item = EmergencyVisit::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        $registrations = Registration::where('type', 'igd')->get();
        return view('emergency-visits.edit', compact('item', 'patients', 'doctors', 'registrations'));
    }
    public function update(Request $request, $id)
    {
        $visit = EmergencyVisit::findOrFail($id);
        $validated = $request->validate([
            'registration_id' => 'nullable|exists:registrations,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'triage' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'complaint' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'disposition' => 'nullable|string',
            'arrival_time' => 'nullable|date',
            'discharge_time' => 'nullable|date',
        ]);
        $visit->update($validated);
        return redirect()->route('emergency-visits.index')->with('success', 'Data kunjungan IGD berhasil diupdate');
    }
    public function destroy($id) { EmergencyVisit::findOrFail($id)->delete(); return redirect()->route('emergency-visits.index')->with('success', 'Data kunjungan IGD berhasil dihapus'); }
}
