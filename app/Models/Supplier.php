<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Supplier extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'phone', 'email', 'address', 'pic_name', 'pic_phone', 'notes', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
}
