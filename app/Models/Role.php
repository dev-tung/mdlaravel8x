<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // 1 Role có thể có nhiều User
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Nếu role có nhiều permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
