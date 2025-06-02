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
            'role' => $this->rolePermissions->map(function ($permission) {
                return $permission->getRoles->name;
            })->values(),
            "roles_modules_permissions" => $this->rolePermissions
                ->flatMap(function ($permission) {
                    $role = $permission->getRoles;
                    return $role->getAccessibleModules->map(function ($modulePermission) use ($role) {
                        return [
                            'role' => $role,
                            'module' => $modulePermission->module,
                            'permission' => $modulePermission->permission,
                        ];
                    });
                })
                ->groupBy(function ($item) {
                    return $item['module']->id ?? null;
                })
                ->map(function ($group) {
                    $first = $group->first();
                    $role = $first['role'];
                    $module = $first['module'];

                    $permissions = collect($group)
                        ->map(fn($item) => $item['permission'])
                        ->filter()
                        ->unique('id')
                        ->values();

                    return [
                        'role' => $role->name ?? null,
                        'module' => $module->name ?? null,
                        'slug' => $module->slug ?? null,
                        'description' => $module->description ?? null,
                        'guards' => $permissions->map(fn($p) => $p->guard_name)->values(),
                        'methods' => $permissions->map(fn($p) => $p->method)->values(),
                        'permissions' => $permissions->map(fn($p) => $p->name)->values(),
                    ];
                })
                ->values(),
            'account_created_at' => $this->created_at,
            'account_updated_at' => $this->updated_at,
        ];
    }
}
