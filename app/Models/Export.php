<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    // Tên bảng
    protected $table = 'exports';

    // Khóa chính
    protected $primaryKey = 'id';

    // Cho phép Laravel tự quản lý created_at, updated_at
    public $timestamps = true;

    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'customer_id',
        'export_date',
        'total_export_amount',
        'total_discount_amount',
        'discount_type',
        'notes',
        'status',
        'payment_method',
    ];

    // Chuyển đổi kiểu dữ liệu
    protected $casts = [
        'export_date'          => 'date',
        'total_export_amount'  => 'float',
        'total_discount_amount'=> 'float',
    ];

    /**
     * Quan hệ: Một export thuộc về một customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Quan hệ: Một export có nhiều items
     */
    public function items()
    {
        return $this->hasMany(ExportItem::class, 'export_id');
    }

    /**
     * Accessor: Tổng giá trị sau khi trừ giảm giá
     */
    public function getTotalAfterDiscountAttribute()
    {
        return $this->total_export_amount - ($this->total_discount_amount ?? 0);
    }
}
