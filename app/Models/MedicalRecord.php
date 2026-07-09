<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MedicalRecord extends Model
{
    use SoftDeletes;
    protected $fillable = ['patient_id', 'recordable_type', 'recordable_id', 'diagnosis', 'therapy', 'notes', 'doctor_id'];
    public function patient() { return $this->belongsTo(Patient::class); }
    public function recordable() { return $this->morphTo(); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
}
