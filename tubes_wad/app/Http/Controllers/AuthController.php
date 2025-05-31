<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill; // Tambahkan untuk skill
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class AuthController extends Controller
{
    /**
     * Register new user.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'jurusan' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:255',
            'nomor_handphone' => 'nullable|string|max:20',
            'nama_skill' => 'nullable|string|max:255', // Nama skill dari input
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Untuk upload sertifikasi
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jurusan' => $request->jurusan,
                'angkatan' => $request->angkatan,
                'nomor_handphone' => $request->nomor_handphone,
                'profile_picture' => $request->profile_picture,
                'certificate_path' => $request->certificate_path, 
            ]);

            // Handle Skill (if provided)
            if ($request->filled('nama_skill')) {
                $skill = Skill::firstOrCreate(['nama' => $request->nama_skill]);
                $user->skills()->attach($skill->id);
            }

            // Handle Certificate Upload
            $certificatePath = null;
            if ($request->hasFile('certificate')) {
                $certificatePath = $request->file('certificate')->store('certificates', 'public');
                $user->certificate_path = $certificatePath;
                $user->save();
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user->load('skills'), // Load skills to include in response
                'token' => $token,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Login user.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->load('skills'),
            'token' => $token,
        ]);
    }

    /**
     * Logout user (revoke current token).
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}