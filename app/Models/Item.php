<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Các cột được phép mass assign
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'product_price_input',
        'product_price_output',
        'discount',
        'subtotal',
        'is_gift',
    ];

    /**
     * Quan hệ tới Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Quan hệ tới Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::created(function ($item) {
            // Khi Item mới được tạo thì update tồn kho product
            $item->product()->decrement('quantity', $item->quantity);
        });
    }
}
