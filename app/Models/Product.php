<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'status',
        'supplier_id',
    ];

    // Quan hệ: Product thuộc 1 Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Quan hệ: Product có thể có nhiều Taxonomy (category, tag…)
    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class, 'product_taxonomy');
    }
}
