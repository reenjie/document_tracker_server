<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Auth\AuthController;
use Carbon\Carbon;

class CheckAuthCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie(config('createToken.cookieName'));
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $tokenParts = explode('|', $token);
        $tokenId = $tokenParts[0] ?? null;
        $accessToken = $tokenParts[1] ?? null;
        if (!$tokenId || !$accessToken) {
            return response()->json(['message' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }
        $tokenRecord = PersonalAccessToken::find($tokenId);
        if (!$tokenRecord || !hash_equals($tokenRecord->token, hash('sha256', $accessToken))) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        if ($tokenRecord->expires_at && $tokenRecord->expires_at->isPast()) {
            return AuthController::logout("Token expired");
        }
        if ($tokenRecord->expires_at) {
            $tokenRecord->expires_at = Carbon::parse($tokenRecord->expires_at)->addMinute();
        } else {
            $tokenRecord->expires_at = Carbon::now()->addMinute();
        }
        $tokenRecord->save();
        return $next($request);
    }
}
