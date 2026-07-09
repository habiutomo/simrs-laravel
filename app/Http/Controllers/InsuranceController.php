<?php
namespace App\Http\Controllers;
use App\Models\Insurance;
use Illuminate\Http\Request;
class InsuranceController extends Controller
{
    public function index(Request $request)
    {
        $query = Insurance::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        $items = $query->latest()->paginate(10);
        return view('insurances.index', compact('items'));
    }
    public function create() { return view('insurances.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'coverage_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        Insurance::create($validated);
        return redirect()->route('insurances.index')->with('success', 'Data asuransi berhasil disimpan');
    }
    public function show($id) { $item = Insurance::findOrFail($id); return view('insurances.show', compact('item')); }
    public function edit($id) { $item = Insurance::findOrFail($id); return view('insurances.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $insurance = Insurance::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'coverage_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $insurance->update($validated);
        return redirect()->route('insurances.index')->with('success', 'Data asuransi berhasil diupdate');
    }
    public function destroy($id) { Insurance::findOrFail($id)->delete(); return redirect()->route('insurances.index')->with('success', 'Data asuransi berhasil dihapus'); }
}
