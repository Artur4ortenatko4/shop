<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($attribute) {
            $attribute->categories()->detach();
        });
        static::deleting(function ($attribute) {
            // Видалення зв'язків атрибуту з категоріями
            $attribute->categories()->detach();
        });
    }
}
