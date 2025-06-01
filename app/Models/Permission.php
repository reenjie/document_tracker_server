<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'guard_name',
        'method',
        'description',
    ];

}

// The 'guard_name' field is used to specify the guard for the permission, defaulting to 'api'.