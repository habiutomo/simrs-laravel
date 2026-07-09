<?php
namespace App\Http\Controllers;
use App\Models\Patient;
use Illuminate\Http\Request;
class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('patients.index', compact('items'));
    }
    public function create() { return view('patients.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rm' => 'required|string|max:50|unique:patients,no_rm',
            'nik' => 'nullable|string|max:30|unique:patients,nik',
            'name' => 'required|string|max:255',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:L,P',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'religion' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'marital_status' => 'nullable|string|max:20',
            'mother_name' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
        ]);
        Patient::create($validated);
        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil disimpan');
    }
    public function show($id) { $item = Patient::findOrFail($id); return view('patients.show', compact('item')); }
    public function edit($id) { $item = Patient::findOrFail($id); return view('patients.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $validated = $request->validate([
            'no_rm' => 'required|string|max:50|unique:patients,no_rm,' . $id,
            'nik' => 'nullable|string|max:30|unique:patients,nik,' . $id,
            'name' => 'required|string|max:255',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:L,P',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'religion' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'marital_status' => 'nullable|string|max:20',
            'mother_name' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
        ]);
        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diupdate');
    }
    public function destroy($id) { Patient::findOrFail($id)->delete(); return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus'); }
}
