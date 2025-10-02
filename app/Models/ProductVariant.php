<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';
    protected $fillable = [
        'product_id',
        'sku',
        'color',
        'size',
        'import_price',
        'price_original',
        'price_sale',
        'quantity',
        'thumbnail_image',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    protected static function booted()
    {
        static::creating(function ($variant) {
            if (empty($variant->sku) && $variant->product) {
                $variant->sku = app(\App\Services\ProductService::class)
                    ->generate($variant->product->name, $variant->size, $variant->color);
            }
        });
    }
}
