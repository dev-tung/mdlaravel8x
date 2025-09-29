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
        'supplier_id',
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

    public static function generateSku(string $productName, ?string $size = null, ?string $color = null): string
    {
        // abbreviation từ product name (chỉ lấy ký tự đầu của mỗi từ)
        $abbr = strtoupper(collect(explode(' ', $productName))
            ->map(fn($w) => mb_substr($w, 0, 1))
            ->implode(''));

        $sku = $abbr;

        if ($size) {
            $sku .= '-S' . strtoupper($size);
        }

        if ($color) {
            $sku .= '-C' . strtoupper($color);
        }

        return $sku;
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
