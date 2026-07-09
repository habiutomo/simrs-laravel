<?php
namespace App\Http\Controllers;
use App\Models\MedicineCategory;
use Illuminate\Http\Request;
class MedicineCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicineCategory::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        $items = $query->latest()->paginate(10);
        return view('medicine-categories.index', compact('items'));
    }
    public function create() { return view('medicine-categories.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        MedicineCategory::create($validated);
        return redirect()->route('medicine-categories.index')->with('success', 'Data kategori obat berhasil disimpan');
    }
    public function show($id) { $item = MedicineCategory::findOrFail($id); return view('medicine-categories.show', compact('item')); }
    public function edit($id) { $item = MedicineCategory::findOrFail($id); return view('medicine-categories.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $medicineCategory = MedicineCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $medicineCategory->update($validated);
        return redirect()->route('medicine-categories.index')->with('success', 'Data kategori obat berhasil diupdate');
    }
    public function destroy($id) { MedicineCategory::findOrFail($id)->delete(); return redirect()->route('medicine-categories.index')->with('success', 'Data kategori obat berhasil dihapus'); }
}
