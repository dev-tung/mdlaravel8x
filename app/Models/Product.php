<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'price_output',
        'description',
        'quantity',
        'thumbnail',
        'unit',
        'supplier_id',
        'taxonomy_id',
        'slug'
    ];

    public function getPriceOutputFormattedAttribute()
    {
        return number_format($this->attributes['price_output'], 0, ',', '.') . ' đ';
    }

    /**
     * Tự động sinh slug khi tạo hoặc cập nhật name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Quan hệ: mỗi sản phẩm thuộc về 1 nhà cung cấp
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Quan hệ: mỗi sản phẩm thuộc về 1 taxonomy (danh mục/loại sản phẩm)
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

    // Quan hệ: 1 sản phẩm có thể có nhiều lần nhập hàng
    public function imports()
    {
        return $this->hasMany(Import::class, 'product_id');
    }
}
