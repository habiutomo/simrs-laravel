<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Insurance extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'type', 'coverage_percentage', 'notes', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean', 'coverage_percentage' => 'decimal:2']; }
    public function registrations() { return $this->hasMany(Registration::class); }
    public function patientBills() { return $this->hasMany(PatientBill::class); }
}
