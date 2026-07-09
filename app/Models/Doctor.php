<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Doctor extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'name', 'specialization', 'phone', 'email', 'sip', 'address', 'consultation_fee', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean', 'consultation_fee' => 'decimal:2']; }
    public function schedules() { return $this->hasMany(Schedule::class); }
    public function outpatientVisits() { return $this->hasMany(OutpatientVisit::class); }
    public function inpatientAdmissions() { return $this->hasMany(InpatientAdmission::class); }
    public function medicalRecords() { return $this->hasMany(MedicalRecord::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
}
