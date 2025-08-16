<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
    ];

    // Quan hệ: 1 Order thuộc về 1 Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Quan hệ: 1 Order có nhiều OrderItems (nếu có bảng order_items)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
