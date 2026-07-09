<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;
class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('suppliers.index', compact('items'));
    }
    public function create() { return view('suppliers.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        Supplier::create($validated);
        return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil disimpan');
    }
    public function show($id) { $item = Supplier::findOrFail($id); return view('suppliers.show', compact('item')); }
    public function edit($id) { $item = Supplier::findOrFail($id); return view('suppliers.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $supplier->update($validated);
        return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil diupdate');
    }
    public function destroy($id) { Supplier::findOrFail($id)->delete(); return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil dihapus'); }
}
