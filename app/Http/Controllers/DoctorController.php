<?php
namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;
class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('doctors.index', compact('items'));
    }
    public function create() { return view('doctors.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:doctors,code',
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'sip' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        Doctor::create($validated);
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil disimpan');
    }
    public function show($id) { $item = Doctor::findOrFail($id); return view('doctors.show', compact('item')); }
    public function edit($id) { $item = Doctor::findOrFail($id); return view('doctors.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:doctors,code,' . $id,
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'sip' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $doctor->update($validated);
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diupdate');
    }
    public function destroy($id) { Doctor::findOrFail($id)->delete(); return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus'); }
}
