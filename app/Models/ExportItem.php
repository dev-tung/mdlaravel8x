<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportItem extends Model
{
    protected $table = 'export_items';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'export_id',
        'product_id',
        'quantity',
        'export_price',
        'total_export_price',
        'is_gift',
    ];

    /**
     * Quan hệ: 1 item thuộc về 1 export
     */
    public function export()
    {
        return $this->belongsTo(Export::class, 'export_id');
    }

    /**
     * Quan hệ: 1 item thuộc về 1 product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
