<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class ApiTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'Authorization token not found'], 401);
        }

        $token = str_replace('Bearer ', '', $token);
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        // Optionally set user in request for controller use
        $request->user = $user;

        return $next($request);
    }
}
