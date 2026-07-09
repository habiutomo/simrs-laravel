<?php
namespace App\Http\Controllers;
use App\Models\{Referral, Patient, Doctor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $query = Referral::with(['patient', 'fromDoctor']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('no_rm', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $items = $query->latest()->paginate(10);
        return view('referrals.index', compact('items'));
    }
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        return view('referrals.create', compact('patients', 'doctors'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'from_doctor_id' => 'nullable|exists:doctors,id',
            'to_institution' => 'required|string|max:255',
            'to_doctor' => 'nullable|string|max:255',
            'reason' => 'required|string',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'referral_date' => 'nullable|date',
        ]);
        DB::beginTransaction();
        try {
            $date = now()->format('Ymd');
            $last = Referral::whereDate('created_at', today())->count();
            $validated['referral_number'] = 'REF-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            $validated['referral_date'] = $validated['referral_date'] ?? now();
            Referral::create($validated);
            DB::commit();
            return redirect()->route('referrals.index')->with('success', 'Data rujukan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id) { $item = Referral::with(['patient', 'fromDoctor'])->findOrFail($id); return view('referrals.show', compact('item')); }
    public function edit($id)
    {
        $item = Referral::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::where('is_active', true)->get();
        return view('referrals.edit', compact('item', 'patients', 'doctors'));
    }
    public function update(Request $request, $id)
    {
        $referral = Referral::findOrFail($id);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'from_doctor_id' => 'nullable|exists:doctors,id',
            'to_institution' => 'required|string|max:255',
            'to_doctor' => 'nullable|string|max:255',
            'reason' => 'required|string',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'referral_date' => 'nullable|date',
        ]);
        $referral->update($validated);
        return redirect()->route('referrals.index')->with('success', 'Data rujukan berhasil diupdate');
    }
    public function destroy($id) { Referral::findOrFail($id)->delete(); return redirect()->route('referrals.index')->with('success', 'Data rujukan berhasil dihapus'); }
}
