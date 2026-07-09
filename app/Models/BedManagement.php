<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BedManagement extends Model
{
    protected $fillable = ['room_id', 'inpatient_admission_id', 'status'];
    public function room() { return $this->belongsTo(Room::class); }
    public function inpatientAdmission() { return $this->belongsTo(InpatientAdmission::class); }
}
