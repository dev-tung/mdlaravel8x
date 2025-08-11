<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    // Tên bảng nếu khác 'categories'
    // protected $table = 'categories';

    // Các trường có thể gán hàng loạt (mass assignable)
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'parent_id',  // nếu có danh mục cha
    ];

    /**
     * Các danh mục con (nếu có cấu trúc phân cấp)
     */
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    /**
     * Danh mục cha (nếu có cấu trúc phân cấp)
     */
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Quan hệ với sản phẩm
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
