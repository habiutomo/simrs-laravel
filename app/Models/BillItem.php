<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BillItem extends Model
{
    protected $fillable = ['patient_bill_id', 'item_type', 'item_name', 'quantity', 'unit_price', 'subtotal', 'notes'];
    protected function casts(): array { return ['unit_price' => 'decimal:2', 'subtotal' => 'decimal:2']; }
    public function patientBill() { return $this->belongsTo(PatientBill::class); }
}
