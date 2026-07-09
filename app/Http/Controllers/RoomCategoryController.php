<?php
namespace App\Http\Controllers;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
class RoomCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomCategory::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        $items = $query->latest()->paginate(10);
        return view('room-categories.index', compact('items'));
    }
    public function create() { return view('room-categories.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rate_per_day' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        RoomCategory::create($validated);
        return redirect()->route('room-categories.index')->with('success', 'Data kategori ruang berhasil disimpan');
    }
    public function show($id) { $item = RoomCategory::findOrFail($id); return view('room-categories.show', compact('item')); }
    public function edit($id) { $item = RoomCategory::findOrFail($id); return view('room-categories.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $roomCategory = RoomCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rate_per_day' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $roomCategory->update($validated);
        return redirect()->route('room-categories.index')->with('success', 'Data kategori ruang berhasil diupdate');
    }
    public function destroy($id) { RoomCategory::findOrFail($id)->delete(); return redirect()->route('room-categories.index')->with('success', 'Data kategori ruang berhasil dihapus'); }
}
