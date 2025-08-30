<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'total_amount',
        'notes',
        'status'
    ];

    // Quan hệ 1-N: Purchase có nhiều Import
    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    // Quan hệ N-1: Purchase thuộc về 1 Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
