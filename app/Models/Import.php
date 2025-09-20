<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    // tên bảng
    protected $table = 'imports';

    // khóa chính
    protected $primaryKey = 'id';

    // cho phép Laravel tự quản lý created_at, updated_at
    public $timestamps = true;

    // các cột có thể gán dữ liệu hàng loạt (mass assignment)
    protected $fillable = [
        'supplier_id',
        'import_date',
        'total_import_amount',
        'notes',
        'status',
        'payment_method'
    ];

    /**
     * Quan hệ: Một import thuộc về một supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * (Nếu có bảng import_items) Một import có nhiều items
     */
    public function items()
    {
        return $this->hasMany(ImportItem::class, 'import_id');
    }
}
