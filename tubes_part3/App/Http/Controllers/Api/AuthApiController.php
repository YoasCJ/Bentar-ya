<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class AuthApiController extends Controller
{
    public function showLogin()
    {
        return response()->json([
            'message' => 'Endpoint API login. Silakan kirim kredensial POST ke /api/login.',
            'status' => 'info_api_usage'
        ], 200); 
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users', 
                'password' => 'required|string|min:6|confirmed',
                'department' => 'required|string|max:255', 
                'batch' => 'required|string|max:255', 
                'description' => 'nullable|string|max:1000', 
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'department' => $request->department,
                'batch' => $request->batch,
                'description' => $request->description ?? null,
                'role' => 'user', 
            ]);

            return response()->json([
                'message' => 'Registrasi berhasil!', 
                'user' => $user,
                'token' => $user->createToken('api_token')->plainTextToken
            ], 201); // 201 Created

        } catch (\Illuminate\Validation\ValidationException $e) { 
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors() 
            ], 422); 
        } catch (\Throwable $e) {
            \Log::error('Error pada register: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Terjadi kesalahan server saat registrasi.',
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:255', 
                'password' => 'required|string', 
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Kredensial tidak valid.'], 401);
            }

            $user = Auth::user(); 

            return response()->json([
                'message' => 'Login berhasil!', 
                'user' => $user,
                'token' => $user->createToken('api_token')->plainTextToken
            ], 200); 

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            \Log::error('Error pada login: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Terjadi kesalahan server saat login.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Berhasil logout.'], 200);
        }

        return response()->json(['message' => 'Tidak ada user yang terautentikasi.'], 401); 
    }
}