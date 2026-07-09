<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RadiologyResult extends Model
{
    protected $fillable = ['radiology_request_id', 'findings', 'impression', 'conclusion', 'notes', 'image_url', 'interpreted_at', 'interpreted_by'];
    protected function casts(): array { return ['interpreted_at' => 'datetime']; }
    public function radiologyRequest() { return $this->belongsTo(RadiologyRequest::class); }
    public function interpreter() { return $this->belongsTo(User::class, 'interpreted_by'); }
}
