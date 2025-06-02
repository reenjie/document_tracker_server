<?php

namespace Database\Seeders;

use App\Models\Modules;
use App\Models\Permission;
use App\Models\RoleModulePermission;
use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRolePermission;
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Roles::where("name", "Administrator")->first();
        $permissions = Permission::all();
        $modules = Modules::all();
        foreach ($modules as $row) {
            foreach ($permissions as $permission) {
                RoleModulePermission::create([
                    "role_id" => $roles->id,
                    "module_id" => $row->id,
                    "permission_id" => $permission->id,
                    "description" => $permission->description . "on module :" . $row->name,
                    "is_active" => true,
                ]);
            }
        }



        $roleModulePermissions = RoleModulePermission::all();
        foreach ($roleModulePermissions as $rmp) {

        }

    }
}
