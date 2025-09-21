<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nếu tên bảng không phải là "products" thì khai báo lại
    protected $table = 'products';

    // Khóa chính (mặc định là "id")
    protected $primaryKey = 'id';

    // Các cột được phép fill
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price_original',
        'price_sale',
        'description',
        'quantity',
        'thumbnail_image',
        'unit',
        'supplier_id',
        'taxonomy_id',
    ];

    public function getPriceSaleFormattedAttribute()
    {
        return number_format($this->attributes['price_sale'], 0, ',', '.') . ' đ';
    }

    // Các quan hệ
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

    public function imports()
    {
        return $this->hasMany(Import::class, 'product_id');
    }

    public function exports()
    {
        return $this->hasMany(Export::class, 'product_id');
    }
}
