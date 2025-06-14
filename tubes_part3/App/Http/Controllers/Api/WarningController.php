<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 

class WarningController extends Controller
{
    public function index(Request $request)
    {
        $warnings = Warning::with(['user', 'admin'])->latest()->paginate(10); 
        return response()->json([
            'message' => 'Warnings retrieved successfully.',
            'data' => $warnings
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id', 
            'warning_type' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ], 422); 
        }

        $warning = Warning::create($request->all());

        return response()->json([
            'message' => 'Warning created successfully.',
            'data' => $warning
        ], 201); 
    }

    public function show(int $id)
    {
        $warning = Warning::with(['user', 'admin'])->find($id);

        if (!$warning) {
            return response()->json([
                'message' => 'Warning not found.'
            ], 404); 
        }

        return response()->json([
            'message' => 'Warning retrieved successfully.',
            'data' => $warning
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $warning = Warning::find($id);

        if (!$warning) {
            return response()->json([
                'message' => 'Warning not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|exists:users,id', 
            'admin_id' => 'sometimes|required|exists:users,id',
            'warning_type' => 'sometimes|required|string|max:255',
            'subject' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'status' => ['sometimes', 'required', Rule::in(['sent', 'read', 'resolved', 'pending_action'])],
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ], 422);
        }

        $warning->update($request->all());

        return response()->json([
            'message' => 'Warning updated successfully.',
            'data' => $warning
        ], 200);
    }

    public function destroy(int $id)
    {
        $warning = Warning::find($id);

        if (!$warning) {
            return response()->json([
                'message' => 'Warning not found.'
            ], 404);
        }

        $warning->delete();

        return response()->json([
            'message' => 'Warning deleted successfully.'
        ], 200); 
    }
}