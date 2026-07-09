<?php
namespace App\Http\Controllers;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
class DiagnosisController extends Controller
{
    public function index(Request $request)
    {
        $query = Diagnosis::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('diagnoses.index', compact('items'));
    }
    public function create() { return view('diagnoses.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:diagnoses,code',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        Diagnosis::create($validated);
        return redirect()->route('diagnoses.index')->with('success', 'Data diagnosis berhasil disimpan');
    }
    public function show($id) { $item = Diagnosis::findOrFail($id); return view('diagnoses.show', compact('item')); }
    public function edit($id) { $item = Diagnosis::findOrFail($id); return view('diagnoses.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $diagnosis = Diagnosis::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:diagnoses,code,' . $id,
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $diagnosis->update($validated);
        return redirect()->route('diagnoses.index')->with('success', 'Data diagnosis berhasil diupdate');
    }
    public function destroy($id) { Diagnosis::findOrFail($id)->delete(); return redirect()->route('diagnoses.index')->with('success', 'Data diagnosis berhasil dihapus'); }
}
