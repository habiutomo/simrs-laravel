<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PolyclinicController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MedicineCategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\RadiologyTestController;
use App\Http\Controllers\MedicalServiceController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\OutpatientVisitController;
use App\Http\Controllers\InpatientAdmissionController;
use App\Http\Controllers\EmergencyVisitController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\LabRequestController;
use App\Http\Controllers\RadiologyRequestController;
use App\Http\Controllers\PatientBillController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ScheduleController;

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('polyclinics', PolyclinicController::class);
    Route::resource('room-categories', RoomCategoryController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('medicine-categories', MedicineCategoryController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('lab-tests', LabTestController::class);
    Route::resource('radiology-tests', RadiologyTestController::class);
    Route::resource('medical-services', MedicalServiceController::class);
    Route::resource('insurances', InsuranceController::class);
    Route::resource('diagnoses', DiagnosisController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::resource('registrations', RegistrationController::class);
    Route::resource('outpatient-visits', OutpatientVisitController::class);
    Route::resource('inpatient-admissions', InpatientAdmissionController::class);
    Route::resource('emergency-visits', EmergencyVisitController::class);
    Route::resource('prescriptions', PrescriptionController::class);
    Route::resource('lab-requests', LabRequestController::class);
    Route::resource('radiology-requests', RadiologyRequestController::class);
    Route::resource('patient-bills', PatientBillController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('referrals', ReferralController::class);
    Route::resource('schedules', ScheduleController::class);

    Route::get('/reports/daily', function () { return view('reports.daily'); })->name('reports.daily');
    Route::get('/reports/financial', function () { return view('reports.financial'); })->name('reports.financial');
});
