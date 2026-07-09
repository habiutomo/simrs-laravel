<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = ['payment_number', 'patient_bill_id', 'patient_id', 'amount', 'method', 'status', 'payment_date', 'notes', 'received_by'];
    protected function casts(): array { return ['amount' => 'decimal:2', 'payment_date' => 'datetime']; }
    public function patientBill() { return $this->belongsTo(PatientBill::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function receiver() { return $this->belongsTo(User::class, 'received_by'); }
}
