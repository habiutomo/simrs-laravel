<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RoomCategory extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'description', 'rate_per_day', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean', 'rate_per_day' => 'decimal:2']; }
    public function rooms() { return $this->hasMany(Room::class); }
}
