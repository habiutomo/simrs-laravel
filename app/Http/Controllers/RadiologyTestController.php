<?php
namespace App\Http\Controllers;
use App\Models\RadiologyTest;
use Illuminate\Http\Request;
class RadiologyTestController extends Controller
{
    public function index(Request $request)
    {
        $query = RadiologyTest::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('radiology-tests.index', compact('items'));
    }
    public function create() { return view('radiology-tests.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:radiology_tests,code',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'preparation' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        RadiologyTest::create($validated);
        return redirect()->route('radiology-tests.index')->with('success', 'Data tes radiologi berhasil disimpan');
    }
    public function show($id) { $item = RadiologyTest::findOrFail($id); return view('radiology-tests.show', compact('item')); }
    public function edit($id) { $item = RadiologyTest::findOrFail($id); return view('radiology-tests.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $radiologyTest = RadiologyTest::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:radiology_tests,code,' . $id,
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'preparation' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $radiologyTest->update($validated);
        return redirect()->route('radiology-tests.index')->with('success', 'Data tes radiologi berhasil diupdate');
    }
    public function destroy($id) { RadiologyTest::findOrFail($id)->delete(); return redirect()->route('radiology-tests.index')->with('success', 'Data tes radiologi berhasil dihapus'); }
}
