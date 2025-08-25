<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'taxonomy_id',
        'name',
        'amount',
        'expense_date',
        'note'
    ];

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }
}
