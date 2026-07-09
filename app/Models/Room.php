<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Room extends Model
{
    use SoftDeletes;
    protected $fillable = ['room_category_id', 'room_number', 'name', 'status', 'notes', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function category() { return $this->belongsTo(RoomCategory::class, 'room_category_id'); }
    public function bedManagement() { return $this->hasOne(BedManagement::class); }
}
