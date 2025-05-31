<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillExchangeController extends Controller
{
    /**
     * Get a list of users with their skills.
     * Can be filtered by skill.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = User::with('skills');

        // Filter by skill if 'skill_id' or 'skill_name' is provided
        if ($request->has('skill_id')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->where('skills.id', $request->skill_id);
            });
        } elseif ($request->has('nama_skill')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->where('nama_skill', 'LIKE', '%' . $request->nama_skill . '%');
            });
        }

        $users = $query->get();

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Get a list of all available skills.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSkills()
    {
        $skills = Skill::all();
        return response()->json([
            'skills' => $skills
        ]);
    }

}