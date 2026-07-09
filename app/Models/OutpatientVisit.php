<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OutpatientVisit extends Model
{
    use SoftDeletes;
    protected $fillable = ['registration_id', 'patient_id', 'doctor_id', 'polyclinic_id', 'status', 'queue_number', 'anamnesis', 'diagnosis', 'therapy', 'notes', 'check_in_at', 'check_out_at'];
    protected function casts(): array { return ['check_in_at' => 'datetime', 'check_out_at' => 'datetime']; }
    public function registration() { return $this->belongsTo(Registration::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function polyclinic() { return $this->belongsTo(Polyclinic::class); }
    public function medicalRecords() { return $this->morphMany(MedicalRecord::class, 'recordable'); }
    public function prescriptions() { return $this->morphMany(Prescription::class, 'prescriptable'); }
    public function labRequests() { return $this->morphMany(LabRequest::class, 'labrequestable'); }
    public function radiologyRequests() { return $this->morphMany(RadiologyRequest::class, 'radrequestable'); }
    public function bills() { return $this->morphMany(PatientBill::class, 'billable'); }
}
