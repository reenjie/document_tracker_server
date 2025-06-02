<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\Permission;
use App\Models\Modules;
use App\Models\RoleModulePermission;
class RMPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                "name" => "Administrator",
                "description" => "Has full access to all resources.",
            ],
            [
                "name" => "Editor",
                "description" => "Can edit existing resources.",
            ],
            [
                "name" => "User",
                "description" => "Can have special permissions.",
            ]
        ];

        $permissions = [
            [
                "name" => "Create",
                "guard_name" => "api",
                "method" => "POST",
                "description" => "Permission to create resources.",
            ],
            [
                "name" => "View",
                "guard_name" => "api",
                "method" => "GET",
                "description" => "Permission to view resources.",
            ],
            [
                "name" => "Edit",
                "guard_name" => "api",
                "method" => "PUT",
                "description" => "Permission to edit resources.",
            ],
            [
                "name" => "Delete",
                "guard_name" => "api",
                "method" => "DELETE",
                "description" => "Permission to delete resources.",
            ]
        ];

        $modules = [
            [
                "name" => "Roles",
                "slug" => "roles",
                "description" => "Module for roles.",
            ],
            [
                "name" => "Permissions",
                "slug" => "permissions",
                "description" => "Module for managing permissions.",
            ],
            [
                "name" => "Modules",
                "slug" => "modules",
                "description" => "Module for managing modules.",
            ],
            [
                "name" => "Settings",
                "slug" => "settings",
                "description" => "Module for managing settings.",
            ]
        ];

        foreach ($roles as $row) {
            Roles::create($row);
        }
        foreach ($permissions as $row) {
            Permission::create($row);
        }
        foreach ($modules as $row) {
            Modules::create($row);
        }
    }
}
