<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'type', // ví dụ: category, tag, brand
    ];

    /**
     * Quan hệ: taxonomy cha
     */
    public function parent()
    {
        return $this->belongsTo(Taxonomy::class, 'parent_id');
    }

    /**
     * Quan hệ: taxonomy con
     */
    public function children()
    {
        return $this->hasMany(Taxonomy::class, 'parent_id');
    }
}
