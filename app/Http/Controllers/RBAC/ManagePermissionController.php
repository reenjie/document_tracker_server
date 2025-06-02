<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AssignPermission\AssignRMPRequest;
use App\Http\Requests\AssignPermission\AssignUserRole;
use App\Models\RoleModulePermission;
use App\Models\UserRoles;
use App\Models\User;
use App\Http\Resources\UserRoleResource;
class ManagePermissionController extends Controller
{
    public function assignRoleModulePermissions(AssignRMPRequest $rmpRequest)
    {
        $RMP = RoleModulePermission::create($rmpRequest->all());
        return response()->json([
            'message' => 'Permissions assigned successfully.',
            'data' => $RMP
        ], 201);
    }

    public function assignUserRoleModulePermissions(AssignUserRole $assignUserRolerequest)
    {
        $UserRole = UserRoles::create($assignUserRolerequest->all());
        return response()->json([
            'message' => 'RoleModulePermission assigned to user successfully.',
            'data' => $UserRole
        ], 200);
    }

    public static function getUserRoles($user_id)
    {
        $user = User::find($user_id);
        return response()->json([
            'message' => 'User roles retrieved successfully.',
            'data' => new UserRoleResource($user)
        ], 200);


    }
}
