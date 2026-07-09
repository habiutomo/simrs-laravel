<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Polyclinic extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'name', 'location', 'description', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function schedules() { return $this->hasMany(Schedule::class); }
    public function outpatientVisits() { return $this->hasMany(OutpatientVisit::class); }
    public function registrations() { return $this->hasMany(Registration::class); }
}
