<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Taxonomy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'type',
        'status', // Thêm trường status
    ];

    /**
     * Tự động sinh slug khi tạo hoặc cập nhật name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($taxonomy) {
            if (empty($taxonomy->slug)) {
                $taxonomy->slug = Str::slug($taxonomy->name);
            }
        });

        static::updating(function ($taxonomy) {
            if (empty($taxonomy->slug)) {
                $taxonomy->slug = Str::slug($taxonomy->name);
            }
        });
    }

    // Quan hệ: taxonomy cha
    public function parent()
    {
        return $this->belongsTo(Taxonomy::class, 'parent_id');
    }

    // Quan hệ: taxonomy con
    public function children()
    {
        return $this->hasMany(Taxonomy::class, 'parent_id');
    }

    // Quan hệ: taxonomy có nhiều sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class, 'taxonomy_id');
    }
}