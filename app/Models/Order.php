<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    // Các trường có thể gán giá trị hàng loạt
    protected $fillable = [
        'customer_id',
        'order_date',
        'notes',
        'total_amount',
        'discount_amount',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Quan hệ với bảng order_items
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'id');
    }

    /**
     * Quan hệ với khách hàng
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
