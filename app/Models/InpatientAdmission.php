<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class InpatientAdmission extends Model
{
    use SoftDeletes;
    protected $fillable = ['admission_number', 'registration_id', 'patient_id', 'room_id', 'doctor_id', 'admission_date', 'admission_time', 'discharge_date', 'discharge_time', 'status', 'primary_diagnosis', 'notes'];
    protected function casts(): array { return ['admission_date' => 'date', 'discharge_date' => 'date', 'admission_time' => 'datetime', 'discharge_time' => 'datetime']; }
    public function registration() { return $this->belongsTo(Registration::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function bedTransfers() { return $this->hasMany(BedTransfer::class); }
    public function medicalRecords() { return $this->morphMany(MedicalRecord::class, 'recordable'); }
    public function prescriptions() { return $this->morphMany(Prescription::class, 'prescriptable'); }
    public function labRequests() { return $this->morphMany(LabRequest::class, 'labrequestable'); }
    public function radiologyRequests() { return $this->morphMany(RadiologyRequest::class, 'radrequestable'); }
    public function bills() { return $this->morphMany(PatientBill::class, 'billable'); }
}
