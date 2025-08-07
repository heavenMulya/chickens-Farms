<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|integer|in:1,2',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
            'role' => $request->input('role', 1),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'api_token' => $user->api_token,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate new token on each login
        if (!$user->api_token) {
            $user->api_token = Str::random(60);
            $user->save();
        }

        // Determine redirect URL based on role
      

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'api_token' => $user->api_token,
            //'redirect_url' => $redirectUrl,
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'Token required'], 401);
        }

        $token = str_replace('Bearer ', '', $token);
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'Logged out successfully']);
    }

      public function checkAuth(Request $request)
    {
        $user = $request->user('api');
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'message' => 'Authenticated',
            'user' => $user->only('id', 'name', 'email', 'role')
        ]);
    }

}

