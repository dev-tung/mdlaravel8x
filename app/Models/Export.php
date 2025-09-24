<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    // tên bảng
    protected $table = 'exports';

    // khóa chính
    protected $primaryKey = 'id';

    // cho phép Laravel tự quản lý created_at, updated_at
    public $timestamps = true;

    protected $fillable = [
        'supplier_id',
        'export_date',
        'total_export_amount',
        'notes',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'export_date' => 'date',
    ];
    
    /**
     * Quan hệ: Một export thuộc về một supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * (Nếu có bảng export_items) Một export có nhiều items
     */
    public function items()
    {
        return $this->hasMany(ExportItem::class, 'export_id');
    }
}
