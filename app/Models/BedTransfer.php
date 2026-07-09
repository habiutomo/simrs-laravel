<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BedTransfer extends Model
{
    protected $fillable = ['inpatient_admission_id', 'from_room_id', 'to_room_id', 'transfer_time', 'reason', 'authorized_by'];
    protected function casts(): array { return ['transfer_time' => 'datetime']; }
    public function inpatientAdmission() { return $this->belongsTo(InpatientAdmission::class); }
    public function fromRoom() { return $this->belongsTo(Room::class, 'from_room_id'); }
    public function toRoom() { return $this->belongsTo(Room::class, 'to_room_id'); }
    public function authorizer() { return $this->belongsTo(User::class, 'authorized_by'); }
}
