<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function getAccessibleModules()
    {
        return $this->hasMany(RoleModulePermission::class, 'role_id');
    }


}
