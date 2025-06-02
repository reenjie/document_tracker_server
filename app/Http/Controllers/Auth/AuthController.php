<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\SigninRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\RBAC\ManagePermissionController;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Cookie;
class AuthController extends Controller
{
    public function signin(SigninRequest $signinRequest)
    {
        $user = User::where('email', $signinRequest->email)->first();
        if (!$user || !Hash::check($signinRequest->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
        $tokenResult = $user->createToken('dt_token');
        $token = $tokenResult->plainTextToken;
        $tokenResult->accessToken->expires_at = Carbon::now()->addMinutes(3); //Expires in 3 minutes
        $tokenResult->accessToken->save();
        return $this->createAuthTokenCookie($token, $user);
    }
    private function createAuthTokenCookie($token, $user)
    {
        return response()->json([
            'message' => 'Signin successful',
            'user' => ManagePermissionController::getUserRoles($user->id)->getData(true)['data'],
        ])->cookie(
                config('createToken.cookieName'),
                $token,
                config('createToken.cookieExpires'),
                config('createToken.cookiePath'),
                config('createToken.cookieDomain'),
                config('createToken.cookieSecure'),
                config('createToken.cookieHttpOnly')
            );
    }

    public static function retrieveUserFromToken($token)
    {
        $token = request()->cookie(config('createToken.cookieName'));
        $tokenParts = explode('|', $token);
        $tokenId = $tokenParts[0] ?? null;

        $tokenRecord = PersonalAccessToken::find($tokenId);

        return $tokenRecord->tokenable;
    }

    public static function logout($message = "Logged out successfully")
    {
        $cookie = Cookie::forget(config('createToken.cookieName'))
            ->withPath(config('createToken.cookiePath'))
            ->withDomain(config('createToken.cookieDomain'))
            ->withSecure(config('createToken.cookieSecure'))
            ->withHttpOnly(config('createToken.cookieHttpOnly'))
            ->withSameSite('lax');

        return response()->json(['message' => $message])->cookie($cookie);
    }

}
