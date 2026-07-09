<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Patient extends Model
{
    use SoftDeletes;
    protected $fillable = ['no_rm', 'nik', 'name', 'birth_place', 'birth_date', 'gender', 'address', 'phone', 'blood_type', 'religion', 'occupation', 'marital_status', 'mother_name', 'allergies'];
    protected function casts(): array { return ['birth_date' => 'date']; }
    public function registrations() { return $this->hasMany(Registration::class); }
    public function outpatientVisits() { return $this->hasMany(OutpatientVisit::class); }
    public function inpatientAdmissions() { return $this->hasMany(InpatientAdmission::class); }
    public function emergencyVisits() { return $this->hasMany(EmergencyVisit::class); }
    public function medicalRecords() { return $this->hasMany(MedicalRecord::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function bills() { return $this->hasMany(PatientBill::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function labRequests() { return $this->hasMany(LabRequest::class); }
    public function radiologyRequests() { return $this->hasMany(RadiologyRequest::class); }
}
