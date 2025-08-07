<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userManagement extends Controller
{
    public function index()
    {
        return response()->json(['data' => User::select('id', 'name', 'email', 'role', 'created_at')->paginate(10)]);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer|in:1,2',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['api_token'] = Str::random(60);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->only('id', 'name', 'email', 'role', 'created_at')
        ], 201);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::select('id', 'name', 'email', 'role', 'created_at')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'sometimes|integer|in:1,2',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->only('id', 'name', 'email', 'role', 'created_at')
        ]);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function searching(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = User::select('id', 'name', 'email', 'role', 'created_at');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $users = $query->paginate($perPage);

        return response()->json([
            'data' => $users
        ]);
    }

}

