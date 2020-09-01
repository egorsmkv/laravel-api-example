<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Lucid\Foundation\Http\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = auth()->attempt($credentials);

        if (!$token) {
            return app()->call('App\Http\Controllers\ErrorsController@loginRequired');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param mixed $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        // TTL is one hour
        $ttl = 3600;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl
        ]);
    }
}
