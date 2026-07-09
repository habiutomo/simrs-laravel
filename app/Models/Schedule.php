<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
    use SoftDeletes;
    protected $fillable = ['doctor_id', 'polyclinic_id', 'day_of_week', 'start_time', 'end_time', 'max_patients', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function polyclinic() { return $this->belongsTo(Polyclinic::class); }
}
