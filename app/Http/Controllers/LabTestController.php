<?php
namespace App\Http\Controllers;
use App\Models\LabTest;
use Illuminate\Http\Request;
class LabTestController extends Controller
{
    public function index(Request $request)
    {
        $query = LabTest::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('lab-tests.index', compact('items'));
    }
    public function create() { return view('lab-tests.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'sample_type' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'normal_values' => 'nullable|string',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        LabTest::create($validated);
        return redirect()->route('lab-tests.index')->with('success', 'Data tes lab berhasil disimpan');
    }
    public function show($id) { $item = LabTest::findOrFail($id); return view('lab-tests.show', compact('item')); }
    public function edit($id) { $item = LabTest::findOrFail($id); return view('lab-tests.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $labTest = LabTest::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code,' . $id,
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'sample_type' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'normal_values' => 'nullable|string',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        $labTest->update($validated);
        return redirect()->route('lab-tests.index')->with('success', 'Data tes lab berhasil diupdate');
    }
    public function destroy($id) { LabTest::findOrFail($id)->delete(); return redirect()->route('lab-tests.index')->with('success', 'Data tes lab berhasil dihapus'); }
}
