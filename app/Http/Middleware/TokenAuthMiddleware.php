<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class TokenAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get token from Authorization header
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Token missing'], 401);
        }

        // Remove "Bearer " if present
        $token = str_replace('Bearer ', '', $token);

        // Check token in DB
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        // Attach the user to the request for later use
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}


