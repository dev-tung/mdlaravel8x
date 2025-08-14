<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'price',
        'sale_price',
        'stock',
        'short_description',
        'description',
        'status'
    ];

    // Tự động tạo slug khi gán name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        // Nếu slug chưa có, tự tạo từ name
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value, '-');
        }
    }
}
