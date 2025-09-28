<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'unit',
        'taxonomy_id'
    ];
    
    // Mutator tự động tạo slug từ name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Quan hệ với taxonomy
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

    // Quan hệ với các biến thể
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function variant()
    {
        return $this->hasOne(ProductVariant::class);
        // hoặc hasMany nếu 1 product có nhiều variant
    }

    
}

