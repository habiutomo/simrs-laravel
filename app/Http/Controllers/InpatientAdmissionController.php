<?php
namespace App\Http\Controllers;
use App\Models\{InpatientAdmission, Registration, Patient, Room, Doctor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class InpatientAdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = InpatientAdmission::with(['patient', 'room', 'doctor']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('inpatient-admissions.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $rooms = Room::with('category')->where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $registrations = Registration::whereIn('type', ['ranap', 'inpatient'])->get();
        return view('inpatient-admissions.create', compact('patients', 'rooms', 'doctors', 'registrations'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'nullable|exists:registrations,id',
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'doctor_id' => 'required|exists:doctors,id',
            'admission_date' => 'nullable|date',
            'admission_time' => 'nullable|date',
            'discharge_date' => 'nullable|date',
            'discharge_time' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'primary_diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = InpatientAdmission::whereDate('created_at', today())->count();
            $validated['admission_number'] = 'RI-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['admission_date'] = $validated['admission_date'] ?? now()->toDateString();
            $validated['admission_time'] = $validated['admission_time'] ?? now();
            $validated['status'] = $validated['status'] ?? 'active';
            InpatientAdmission::create($validated);
            DB::commit();
            return redirect()->route('inpatient-admissions.index')->with('success', 'Data rawat inap berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = InpatientAdmission::with(['patient', 'room.category', 'doctor', 'registration'])->findOrFail($id); return view('inpatient-admissions.show', compact('item')); }
    public function edit($id)
    {
        $item = InpatientAdmission::findOrFail($id);
        $patients = Patient::all();
        $rooms = Room::with('category')->where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $registrations = Registration::whereIn('type', ['ranap', 'inpatient'])->get();
        return view('inpatient-admissions.edit', compact('item', 'patients', 'rooms', 'doctors', 'registrations'));
    }
    public function update(Request $request, $id)
    {
        $admission = InpatientAdmission::findOrFail($id);
        $validated = $request->validate([
            'registration_id' => 'nullable|exists:registrations,id',
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'doctor_id' => 'required|exists:doctors,id',
            'admission_date' => 'nullable|date',
            'admission_time' => 'nullable|date',
            'discharge_date' => 'nullable|date',
            'discharge_time' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'primary_diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $admission->update($validated);
        return redirect()->route('inpatient-admissions.index')->with('success', 'Data rawat inap berhasil diupdate');
    }
    public function destroy($id) { InpatientAdmission::findOrFail($id)->delete(); return redirect()->route('inpatient-admissions.index')->with('success', 'Data rawat inap berhasil dihapus'); }
}
