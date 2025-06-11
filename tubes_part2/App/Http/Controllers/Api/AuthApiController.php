<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'department' => 'required|string',
                'batch' => 'required|string',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'department' => $request->department,
                'batch' => $request->batch,
                'description' => $request->description ?? null,
            ]);

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('api_token')->plainTextToken
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Server error on register',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('api_token')->plainTextToken
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Server error on login',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
