<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class ScheduleApiController extends Controller
{
    public function index()
    {
        try {
            $schedules = Schedule::where('user_id', Auth::id())->latest()->get();
            return response()->json($schedules, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching schedules via API: ' . $e->getMessage(), ['user_id' => Auth::id()]);
            return response()->json(['message' => 'Failed to fetch schedules.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            $schedule = Schedule::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return response()->json([
                'message' => 'Schedule item created successfully!',
                'schedule' => $schedule
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating schedule item via API: ' . $e->getMessage(), ['user_id' => Auth::id(), 'request' => $request->all()]);
            return response()->json(['message' => 'Failed to create schedule item.'], 500);
        }
    }

    public function show($id)
    {
        dd(
            'Is Authenticated: ' . Auth::check(),
            'Auth ID: ' . Auth::id(),
            'Auth User Object: ', Auth::user()
        );
        try {
            $schedule = Schedule::where('user_id', Auth::id())->find($id);

            if (!$schedule) {
                return response()->json(['message' => 'Schedule item not found.'], 404);
            }

            return response()->json($schedule, 200);

        } catch (\Exception $e) {
            Log::error('Error fetching single schedule item via API:', [
                'user_id' => Auth::id(),
                'schedule_id' => $id,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['message' => 'Failed to fetch schedule item.'], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $schedule = Schedule::where('user_id', Auth::id())->find($id);

            if (!$schedule) {
                return response()->json(['message' => 'Schedule item not found.'], 404);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            $schedule->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return response()->json([
                'message' => 'Schedule item updated successfully!',
                'schedule' => $schedule
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating schedule item via API: ' . $e->getMessage(), ['user_id' => Auth::id(), 'schedule_id' => $id, 'request' => $request->all()]);
            return response()->json(['message' => 'Failed to update schedule item.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $schedule = Schedule::where('user_id', Auth::id())->find($id);

            if (!$schedule) {
                return response()->json(['message' => 'Schedule item not found.'], 404);
            }

            $schedule->delete();

            return response()->json(['message' => 'Schedule item deleted successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting schedule item via API: ' . $e->getMessage(), ['user_id' => Auth::id(), 'schedule_id' => $id]);
            return response()->json(['message' => 'Failed to delete schedule item.'], 500);
        }
    }
}