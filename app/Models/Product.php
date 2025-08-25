<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'price_input',
        'price_output',
        'description',
        'quantity',
        'thumbnail',
        'unit',
        'supplier_id',
        'taxonomy_id'
    ];

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
}
