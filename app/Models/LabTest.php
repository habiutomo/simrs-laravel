<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LabTest extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'name', 'category', 'sample_type', 'price', 'description', 'normal_values', 'unit', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean', 'price' => 'decimal:2']; }
    public function labRequests() { return $this->hasMany(LabRequest::class); }
    public function labResults() { return $this->hasMany(LabResult::class); }
}
