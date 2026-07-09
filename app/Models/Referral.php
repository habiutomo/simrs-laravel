<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Referral extends Model
{
    use SoftDeletes;
    protected $fillable = ['referral_number', 'patient_id', 'from_doctor_id', 'to_institution', 'to_doctor', 'reason', 'diagnosis', 'notes', 'status', 'referral_date'];
    protected function casts(): array { return ['referral_date' => 'datetime']; }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function fromDoctor() { return $this->belongsTo(Doctor::class, 'from_doctor_id'); }
}
