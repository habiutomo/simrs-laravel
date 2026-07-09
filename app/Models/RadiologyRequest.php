<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RadiologyRequest extends Model
{
    use SoftDeletes;
    protected $fillable = ['request_number', 'patient_id', 'doctor_id', 'radiology_test_id', 'radrequestable_type', 'radrequestable_id', 'priority', 'status', 'clinical_info', 'requested_at', 'completed_at', 'radiologist_id'];
    protected function casts(): array { return ['requested_at' => 'datetime', 'completed_at' => 'datetime']; }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function radiologyTest() { return $this->belongsTo(RadiologyTest::class); }
    public function radrequestable() { return $this->morphTo(); }
    public function result() { return $this->hasOne(RadiologyResult::class); }
}
