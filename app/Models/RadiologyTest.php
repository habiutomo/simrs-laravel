<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RadiologyTest extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'name', 'category', 'price', 'description', 'preparation', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean', 'price' => 'decimal:2']; }
    public function radiologyRequests() { return $this->hasMany(RadiologyRequest::class); }
}
