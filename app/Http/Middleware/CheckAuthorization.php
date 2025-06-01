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
        $module = request()->segment(2);
        return response()->json([
            'message' => 'Im at Authorization Middleware',
            'module' => $module,
            'method' => request()->method(),
            'token' => $token,
            'user' =>
                ManagePermissionController::getUserRoles(
                    AuthController::retrieveUserFromToken($token)->id
                )
                    ->getData(true)['data'],
        ], 271);


        return $next($request);
    }
}
