<?php
namespace App\Http\Controllers;
use App\Models\MedicalService;
use Illuminate\Http\Request;
class MedicalServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalService::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        $items = $query->latest()->paginate(10);
        return view('medical-services.index', compact('items'));
    }
    public function create() { return view('medical-services.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:medical_services,code',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        MedicalService::create($validated);
        return redirect()->route('medical-services.index')->with('success', 'Data layanan medis berhasil disimpan');
    }
    public function show($id) { $item = MedicalService::findOrFail($id); return view('medical-services.show', compact('item')); }
    public function edit($id) { $item = MedicalService::findOrFail($id); return view('medical-services.edit', compact('item')); }
    public function update(Request $request, $id)
    {
        $medicalService = MedicalService::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:medical_services,code,' . $id,
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $medicalService->update($validated);
        return redirect()->route('medical-services.index')->with('success', 'Data layanan medis berhasil diupdate');
    }
    public function destroy($id) { MedicalService::findOrFail($id)->delete(); return redirect()->route('medical-services.index')->with('success', 'Data layanan medis berhasil dihapus'); }
}
