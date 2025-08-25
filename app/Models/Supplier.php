<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // Nếu muốn lấy sản phẩm của nhà cung cấp
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
