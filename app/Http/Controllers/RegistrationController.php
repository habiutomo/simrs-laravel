<?php
namespace App\Http\Controllers;
use App\Models\{Registration, Patient, Polyclinic, Doctor, Insurance};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['patient', 'polyclinic', 'doctor']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('registrations.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $insurances = Insurance::where('is_active', true)->get();
        return view('registrations.create', compact('patients', 'polyclinics', 'doctors', 'insurances'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'polyclinic_id' => 'nullable|exists:polyclinics,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'insurance_id' => 'nullable|exists:insurances,id',
            'type' => 'required|string|max:50',
            'status' => 'nullable|string|max:50',
            'complaint' => 'nullable|string',
            'referral_from' => 'nullable|string|max:255',
            'registered_by' => 'nullable|exists:users,id',
            'registration_time' => 'nullable|date',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $lastReg = Registration::whereDate('created_at', today())->count();
            $validated['registration_number'] = 'REG-' . $date . '-' . str_pad($lastReg + 1, 4, '0', STR_PAD_LEFT);
            $validated['registration_time'] = $validated['registration_time'] ?? now();
            Registration::create($validated);
            DB::commit();
            return redirect()->route('registrations.index')->with('success', 'Data pendaftaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = Registration::with(['patient', 'polyclinic', 'doctor', 'insurance'])->findOrFail($id); return view('registrations.show', compact('item')); }
    public function edit($id)
    {
        $item = Registration::findOrFail($id);
        $patients = Patient::all();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $insurances = Insurance::where('is_active', true)->get();
        return view('registrations.edit', compact('item', 'patients', 'polyclinics', 'doctors', 'insurances'));
    }
    public function update(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'polyclinic_id' => 'nullable|exists:polyclinics,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'insurance_id' => 'nullable|exists:insurances,id',
            'type' => 'required|string|max:50',
            'status' => 'nullable|string|max:50',
            'complaint' => 'nullable|string',
            'referral_from' => 'nullable|string|max:255',
            'registered_by' => 'nullable|exists:users,id',
            'registration_time' => 'nullable|date',
        ]);
        $registration->update($validated);
        return redirect()->route('registrations.index')->with('success', 'Data pendaftaran berhasil diupdate');
    }
    public function destroy($id) { Registration::findOrFail($id)->delete(); return redirect()->route('registrations.index')->with('success', 'Data pendaftaran berhasil dihapus'); }
}
