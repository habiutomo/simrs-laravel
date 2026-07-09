<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PatientBill extends Model
{
    use SoftDeletes;
    protected $fillable = ['bill_number', 'patient_id', 'registration_id', 'insurance_id', 'billable_type', 'billable_id', 'subtotal', 'insurance_coverage', 'discount', 'total', 'status', 'notes'];
    protected function casts(): array { return ['subtotal' => 'decimal:2', 'insurance_coverage' => 'decimal:2', 'discount' => 'decimal:2', 'total' => 'decimal:2']; }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function registration() { return $this->belongsTo(Registration::class); }
    public function insurance() { return $this->belongsTo(Insurance::class); }
    public function billable() { return $this->morphTo(); }
    public function items() { return $this->hasMany(BillItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
