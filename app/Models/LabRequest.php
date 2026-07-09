<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LabRequest extends Model
{
    use SoftDeletes;
    protected $fillable = ['request_number', 'patient_id', 'doctor_id', 'lab_test_id', 'labrequestable_type', 'labrequestable_id', 'priority', 'status', 'notes', 'requested_at', 'sampled_at', 'completed_at', 'sampled_by', 'processed_by'];
    protected function casts(): array { return ['requested_at' => 'datetime', 'sampled_at' => 'datetime', 'completed_at' => 'datetime']; }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function labTest() { return $this->belongsTo(LabTest::class); }
    public function labrequestable() { return $this->morphTo(); }
    public function results() { return $this->hasMany(LabResult::class); }
}
