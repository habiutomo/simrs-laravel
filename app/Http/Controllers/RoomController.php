<?php
namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('category');
        if ($request->filled('room_category_id')) {
            $query->where('room_category_id', $request->room_category_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('room_number', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        $roomCategories = RoomCategory::where('is_active', true)->get();
        return view('rooms.index', compact('items', 'roomCategories'));
    }
    public function create()
    {
        $roomCategories = RoomCategory::where('is_active', true)->get();
        return view('rooms.create', compact('roomCategories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_category_id' => 'required|exists:room_categories,id',
            'room_number' => 'required|string|max:20|unique:rooms,room_number',
            'name' => 'required|string|max:255',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Data ruang berhasil disimpan');
    }
    public function show($id) { $item = Room::with('category')->findOrFail($id); return view('rooms.show', compact('item')); }
    public function edit($id)
    {
        $item = Room::findOrFail($id);
        $roomCategories = RoomCategory::where('is_active', true)->get();
        return view('rooms.edit', compact('item', 'roomCategories'));
    }
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $validated = $request->validate([
            'room_category_id' => 'required|exists:room_categories,id',
            'room_number' => 'required|string|max:20|unique:rooms,room_number,' . $id,
            'name' => 'required|string|max:255',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Data ruang berhasil diupdate');
    }
    public function destroy($id) { Room::findOrFail($id)->delete(); return redirect()->route('rooms.index')->with('success', 'Data ruang berhasil dihapus'); }
}
