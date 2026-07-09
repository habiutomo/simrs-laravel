<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Medicine extends Model
{
    use SoftDeletes;
    protected $fillable = ['medicine_category_id', 'code', 'name', 'generic_name', 'unit', 'price', 'stock', 'min_stock', 'description', 'expired_date', 'manufacturer', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean', 'price' => 'decimal:2', 'expired_date' => 'date']; }
    public function category() { return $this->belongsTo(MedicineCategory::class, 'medicine_category_id'); }
    public function prescriptionItems() { return $this->hasMany(PrescriptionItem::class); }
}
