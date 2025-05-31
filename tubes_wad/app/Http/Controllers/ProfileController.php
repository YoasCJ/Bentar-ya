<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::all();
        return response()->json($profile);
    }
    
    /**
     * Get authenticated user's profile.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load('skills')
        ]);
    }

    /**
     * Update authenticated user's profile.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'jurusan' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:255',
            'nomor_handphone' => 'nullable|string|max:20',
            'nama_skill' => 'nullable|string|max:255', // Nama skill dari input
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Untuk upload sertifikasi
            'profile_picture' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Untuk upload picture   
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $user->fill($request->only([
                'nama', 'email', 'jurusan', 'angkatan', 'nomor_handphone'
            ]));

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Handle Profile Picture Upload
            if ($request->hasFile('profile_picture')) {
                // Delete old picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $profilePicturePath;
            }

            $user->save();

            // Sync Skills
            if ($request->has('skills')) {
                $skillIds = [];
                foreach ($request->skills as $skillName) {
                    $skill = Skill::firstOrCreate(['name' => $skillName]);
                    $skillIds[] = $skill->id;
                }
                $user->skills()->sync($skillIds); // Sync will detach old skills and attach new ones
            }

            DB::commit();

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user->load('skills')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Profile update failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        $user = $request->user(); // Kalau pakai sanctum atau token

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

}