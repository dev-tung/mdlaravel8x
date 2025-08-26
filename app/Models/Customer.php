<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
        'taxonomy_id',
        'status'
    ];

    /**
     * Ẩn password khi trả về JSON
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Quan hệ: Mỗi khách hàng thuộc về 1 taxonomy (nhóm khách hàng)
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }
}
