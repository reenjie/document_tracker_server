<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RBAC\ManagePermissionController;

class CheckAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->cookie(config('createToken.cookieName'));
        $senderGuardName = request()->segment(1);
        $sendermoduleRequest = request()->segment(2);

        $userAccess = ManagePermissionController::getUserRoles(
            AuthController::retrieveUserFromToken($token)->id
        )
            ->getData(true)['data'];


        /**
         * Check if the user has access to the module
         * 
         */


        $hasModuleAccess = array_filter($userAccess['roles_modules_permissions'], function ($roleModulePermission) use ($sendermoduleRequest) {
            return $roleModulePermission['slug'] === $sendermoduleRequest;
        });

        if (!count($hasModuleAccess) || count($hasModuleAccess) === 0) {
            return response()->json([
                'message' => 'Access Denied',
            ], 401);
        }

        /**
         * The User is authorized to access the module, now we need to check if the user has permission to access the specific method and routes
         */
        $hasPermission = array_filter($hasModuleAccess, function ($permission) use ($request, $senderGuardName) {
            return array_filter($permission['methods'], fn($method) => $method === $request->method())
                && array_filter($permission['guards'], fn($guard) => $guard === $senderGuardName);
        });


        if (count($hasPermission) === 0) {
            return response()->json([
                'message' => 'You do not have permission to access this resource',
            ], 401);
        }

        /**
         * User is authorized to access the module and has permission to access the method
         */
        return $next($request);
    }
}
