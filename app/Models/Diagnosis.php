<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Diagnosis extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'name', 'category', 'description', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
}
