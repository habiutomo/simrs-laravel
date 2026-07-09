<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Prescription extends Model
{
    use SoftDeletes;
    protected $fillable = ['prescription_number', 'patient_id', 'doctor_id', 'prescriptable_type', 'prescriptable_id', 'status', 'notes', 'prescribed_at', 'dispensed_at', 'dispensed_by'];
    protected function casts(): array { return ['prescribed_at' => 'datetime', 'dispensed_at' => 'datetime']; }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function prescriptable() { return $this->morphTo(); }
    public function items() { return $this->hasMany(PrescriptionItem::class); }
    public function dispenser() { return $this->belongsTo(User::class, 'dispensed_by'); }
}
