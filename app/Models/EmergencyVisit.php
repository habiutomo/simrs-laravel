<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmergencyVisit extends Model
{
    use SoftDeletes;
    protected $fillable = ['emergency_number', 'registration_id', 'patient_id', 'doctor_id', 'triage', 'status', 'complaint', 'diagnosis', 'treatment', 'disposition', 'arrival_time', 'discharge_time'];
    protected function casts(): array { return ['arrival_time' => 'datetime', 'discharge_time' => 'datetime']; }
    public function registration() { return $this->belongsTo(Registration::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function medicalRecords() { return $this->morphMany(MedicalRecord::class, 'recordable'); }
    public function prescriptions() { return $this->morphMany(Prescription::class, 'prescriptable'); }
    public function labRequests() { return $this->morphMany(LabRequest::class, 'labrequestable'); }
    public function radiologyRequests() { return $this->morphMany(RadiologyRequest::class, 'radrequestable'); }
    public function bills() { return $this->morphMany(PatientBill::class, 'billable'); }
}
