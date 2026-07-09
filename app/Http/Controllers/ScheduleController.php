<?php
namespace App\Http\Controllers;
use App\Models\{Schedule, Doctor, Polyclinic};
use Illuminate\Http\Request;
class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['doctor', 'polyclinic']);
        if ($request->filled('doctor_id')) $query->where('doctor_id', $request->doctor_id);
        if ($request->filled('polyclinic_id')) $query->where('polyclinic_id', $request->polyclinic_id);
        if ($request->filled('day_of_week')) $query->where('day_of_week', $request->day_of_week);
        $items = $query->latest()->paginate(10);
        $doctors = Doctor::where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('schedules.index', compact('items', 'doctors', 'polyclinics'));
    }
    public function create()
    {
        $doctors = Doctor::where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('schedules.create', compact('doctors', 'polyclinics'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'day_of_week' => 'required|string|max:20',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'max_patients' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        Schedule::create($validated);
        return redirect()->route('schedules.index')->with('success', 'Data jadwal berhasil disimpan');
    }
    public function show($id) { $item = Schedule::with(['doctor', 'polyclinic'])->findOrFail($id); return view('schedules.show', compact('item')); }
    public function edit($id)
    {
        $item = Schedule::findOrFail($id);
        $doctors = Doctor::where('is_active', true)->get();
        $polyclinics = Polyclinic::where('is_active', true)->get();
        return view('schedules.edit', compact('item', 'doctors', 'polyclinics'));
    }
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'day_of_week' => 'required|string|max:20',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'max_patients' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $schedule->update($validated);
        return redirect()->route('schedules.index')->with('success', 'Data jadwal berhasil diupdate');
    }
    public function destroy($id) { Schedule::findOrFail($id)->delete(); return redirect()->route('schedules.index')->with('success', 'Data jadwal berhasil dihapus'); }
}
