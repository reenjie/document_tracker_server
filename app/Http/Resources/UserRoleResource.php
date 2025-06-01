<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            'roles' => collect($this->rolePermissions->map(function ($permission) {
                $role = $permission->roleModulePermission->role;
                if ($role->is_active) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'description' => $role->description,
                    ];
                }
                return null;
            })->filter())->unique('id')->values(),
            "roles_modules_permissions" => $this->rolePermissions
                ->groupBy(function ($permission) {
                    return $permission->roleModulePermission->module->id;
                })
                ->map(function ($group) {
                    $first = $group->first();
                    $module = $first->roleModulePermission->module;

                    // Collect and remove duplicate permissions based on ID
                    $permissions = $group
                        ->map(function ($permission) {
                        return $permission->roleModulePermission->permission;
                    })
                        ->unique('id') // ensure uniqueness by permission ID
                        ->values();    // reindex the array
        
                    return [
                        'role' => $first->roleModulePermission->role->name,
                        'module' => $module->name,
                        'slug' => $module->slug,
                        'description' => $module->description,
                        'methods' => $permissions->map(function ($permit) {
                            return $permit->method;
                        })->values(),
                        'permissions' => $permissions->map(function ($permit) {
                            return $permit->name;
                        })->values(),
                    ];
                })->values(),
            'account_created_at' => $this->created_at,
            'account_updated_at' => $this->updated_at,
        ];
    }
}
