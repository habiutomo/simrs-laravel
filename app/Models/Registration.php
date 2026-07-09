<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Registration extends Model
{
    use SoftDeletes;
    protected $fillable = ['patient_id', 'polyclinic_id', 'doctor_id', 'insurance_id', 'registration_number', 'type', 'status', 'complaint', 'referral_from', 'registered_by', 'registration_time'];
    protected function casts(): array { return ['registration_time' => 'datetime']; }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function polyclinic() { return $this->belongsTo(Polyclinic::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function insurance() { return $this->belongsTo(Insurance::class); }
    public function registrar() { return $this->belongsTo(User::class, 'registered_by'); }
    public function outpatientVisit() { return $this->hasOne(OutpatientVisit::class); }
    public function inpatientAdmission() { return $this->hasOne(InpatientAdmission::class); }
    public function emergencyVisit() { return $this->hasOne(EmergencyVisit::class); }
    public function patientBill() { return $this->hasOne(PatientBill::class); }
}
