<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $table = 'imports';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'product_price_input',
        'total_price'
    ];

    /**
     * Liên kết tới phiếu nhập (purchases)
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    /**
     * Liên kết tới sản phẩm (products)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
