<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportItem extends Model
{
    protected $table = 'import_items';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'import_id',
        'product_id',
        'quantity',
        'import_price',
        'total_import_price',
        'is_gift',
    ];

    /**
     * Quan hệ: 1 item thuộc về 1 import
     */
    public function import()
    {
        return $this->belongsTo(Import::class, 'import_id');
    }

    /**
     * Quan hệ: 1 item thuộc về 1 product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
