<?php
namespace App\Http\Controllers;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use Illuminate\Http\Request;
class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::with('category');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('medicine_category_id')) {
            $query->where('medicine_category_id', $request->medicine_category_id);
        }
        if ($request->filled('stock_filter')) {
            if ($request->stock_filter === 'low') {
                $query->whereColumn('stock', '<=', 'min_stock');
            } elseif ($request->stock_filter === 'out') {
                $query->where('stock', 0);
            }
        }
        $items = $query->latest()->paginate(10);
        $categories = MedicineCategory::where('is_active', true)->get();
        return view('medicines.index', compact('items', 'categories'));
    }
    public function create()
    {
        $categories = MedicineCategory::where('is_active', true)->get();
        return view('medicines.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_category_id' => 'nullable|exists:medicine_categories,id',
            'code' => 'required|string|max:50|unique:medicines,code',
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'expired_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);
        Medicine::create($validated);
        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil disimpan');
    }
    public function show($id) { $item = Medicine::with('category')->findOrFail($id); return view('medicines.show', compact('item')); }
    public function edit($id)
    {
        $item = Medicine::findOrFail($id);
        $categories = MedicineCategory::where('is_active', true)->get();
        return view('medicines.edit', compact('item', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $validated = $request->validate([
            'medicine_category_id' => 'nullable|exists:medicine_categories,id',
            'code' => 'required|string|max:50|unique:medicines,code,' . $id,
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'expired_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);
        $medicine->update($validated);
        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil diupdate');
    }
    public function destroy($id) { Medicine::findOrFail($id)->delete(); return redirect()->route('medicines.index')->with('success', 'Data obat berhasil dihapus'); }
}
