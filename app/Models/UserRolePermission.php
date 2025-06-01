<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    protected $fillable = [
        'user_id',
        'user_role_permission_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roleModulePermission()
    {
        return $this->belongsTo(RoleModulePermission::class, 'user_role_permission_id');
    }
}
