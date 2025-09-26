<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Taxonomy;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

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
        'import_price'
    ];
    
    // Mutator tự động tạo slug từ name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value); // chuyển name thành slug
    }

    // Accessor format giá
    public function getPriceSaleFormattedAttribute()
    {
        return number_format($this->attributes['price_sale'], 0, ',', '.') . ' đ';
    }

    public function getPriceOriginalFormattedAttribute()
    {
        return number_format($this->attributes['price_original'], 0, ',', '.') . ' đ';
    }

    // Quan hệ
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

    // Quan hệ với ImportItem
    public function importItems()
    {
        return $this->hasMany(ImportItem::class, 'product_id');
    }

    // Quan hệ với Import qua ImportItem
    public function imports()
    {
        return $this->hasManyThrough(
            Import::class,       // Model cuối
            ImportItem::class,   // Model trung gian
            'product_id',        // Khóa ngoại trên bảng import_items
            'id',                // Khóa chính trên bảng imports
            'id',                // Khóa chính trên bảng products
            'import_id'          // Khóa ngoại liên kết trên import_items
        );
    }
}
