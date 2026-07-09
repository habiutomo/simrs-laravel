<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LabResult extends Model
{
    protected $fillable = ['lab_request_id', 'lab_test_id', 'parameter', 'result', 'normal_range', 'unit', 'notes'];
    public function labRequest() { return $this->belongsTo(LabRequest::class); }
    public function labTest() { return $this->belongsTo(LabTest::class); }
}
