<?php
namespace App\Http\Controllers;
use App\Models\{Patient, Registration, OutpatientVisit, InpatientAdmission, EmergencyVisit, Prescription, PatientBill};
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $todayRegistrations = Registration::whereDate('registration_time', today())->count();
        $activeInpatients = InpatientAdmission::where('status', 'active')->count();
        $todayVisits = OutpatientVisit::whereDate('created_at', today())->count();
        $pendingBills = PatientBill::where('status', 'unpaid')->count();
        $weeklyVisits = OutpatientVisit::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')->orderBy('date')->get();
        return view('dashboard', compact('totalPatients', 'todayRegistrations', 'activeInpatients', 'todayVisits', 'pendingBills', 'weeklyVisits'));
    }
}
