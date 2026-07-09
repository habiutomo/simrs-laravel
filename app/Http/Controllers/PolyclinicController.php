<?php
namespace App\Http\Controllers;
use App\Models\Polyclinic;
use Illuminate\Http\Request;
class PolyclinicController extends Controller
{
    public function index(Request $request)
    {
        $query = Polyclinic::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('polyclinics.index', compact('items'));
    }
    public function create() { return view('polyclinics.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:polyclinics,code',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        Polyclinic::create($validated);
        return redirect()->route('polyclinics.index')->with('success', 'Data poliklinik berhasil disimpan');
    }
    public function show($id) { $item = Polyclinic::findOrFail($id); return view('polyclinics.show', compact('item')); }
    public function edit($id) { $item = Polyclinic::findOrFail($id); return view('polyclinics.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $polyclinic = Polyclinic::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:polyclinics,code,' . $id,
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $polyclinic->update($validated);
        return redirect()->route('polyclinics.index')->with('success', 'Data poliklinik berhasil diupdate');
    }
    public function destroy($id) { Polyclinic::findOrFail($id)->delete(); return redirect()->route('polyclinics.index')->with('success', 'Data poliklinik berhasil dihapus'); }
}
