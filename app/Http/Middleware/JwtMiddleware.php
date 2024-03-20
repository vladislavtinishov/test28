<?php

namespace App\Http\Middleware;

use App\Http\Services\JwtManager;
use App\Models\User;
use Closure;
use http\Exception\BadHeaderException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwtManager = new JwtManager;
        $token = $request->header('Authorization');
        if (!$token) return response()->json(['message' => 'Unauthorized'], 401);

        $token = explode(' ', $token);
        $token = $token[1] ?? false;
        if (!$token) return response()->json(['message' => 'Unauthorized'], 401);

        $payload = $jwtManager->decodeToken($token);
        $userId = $payload['user_id'];
        $user = User::query()->find($userId);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}
