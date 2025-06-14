<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller; 
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< Updated upstream
use Illuminate\Support\Facades\Log;
=======
use Illuminate\Support\Facades\Log; 
>>>>>>> Stashed changes

class ScheduleApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); 
    }

    public function index()
    {
<<<<<<< Updated upstream
        $schedules = Schedule::where('user1_id', Auth::id())
            ->orWhere('user2_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->with(['user1', 'user2'])
            ->get();

        return response()->json([
            'message' => 'Schedules fetched successfully.',
            'data' => $schedules
        ], 200);
=======
        try {
            $schedules = Schedule::where('user1_id', Auth::id())
                                 ->orWhere('user2_id', Auth::id())
                                 ->with(['user1', 'user2']) 
                                 ->orderBy('scheduled_at', 'desc')
                                 ->paginate(10);

            return response()->json([
                'data' => $schedules->items(), 
                'meta' => [ 
                    'current_page' => $schedules->currentPage(),
                    'last_page' => $schedules->lastPage(),
                    'per_page' => $schedules->perPage(),
                    'total' => $schedules->total(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in ScheduleApiController@index: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to retrieve schedules.', 'error' => $e->getMessage()], 500);
        }
>>>>>>> Stashed changes
    }

    public function store(Request $request)
    {
<<<<<<< Updated upstream
        Log::info('Current authenticated user ID', ['user_id' => Auth::id()]);

        try {
            $request->validate([
                'user2_id' => 'required|exists:users,id|different:' . Auth::id(),
                'scheduled_at' => 'required|date|after:now',
                'method' => 'required|in:online,offline',
                'notes' => 'nullable|string',
            ]);
=======
        $request->validate([
            'user2_id' => 'required|exists:users,id|different:user1_id', 
            'scheduled_at' => 'required|date|after:now',
            'method' => 'required|in:online,offline',
            'notes' => 'nullable|string',
        ]);
>>>>>>> Stashed changes

        try {
            $schedule = Schedule::create([
<<<<<<< Updated upstream
                'user1_id' => Auth::id(),
=======
                'user1_id' => Auth::id(), 
>>>>>>> Stashed changes
                'user2_id' => $request->user2_id,
                'scheduled_at' => $request->scheduled_at,
                'method' => $request->method,
                'notes' => $request->notes,
<<<<<<< Updated upstream
                'status' => 'upcoming',
            ]);

            return response()->json([
                'message' => 'Schedule created successfully!',
                'data' => $schedule
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('API Schedule Store Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request' => $request->all()
            ]);
            
            return response()->json(['message' => 'Failed to create schedule.'], 500);
=======
                'status' => 'upcoming', 
            ]);

            return response()->json(['message' => 'Schedule created successfully!', 'schedule' => $schedule], 201);
        } catch (\Exception $e) {
            Log::error('Error in ScheduleApiController@store: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to create schedule.', 'error' => $e->getMessage()], 500);
>>>>>>> Stashed changes
        }
    }

    public function show(Schedule $schedule)
    {
<<<<<<< Updated upstream
        \Log::info('User:', [auth()->user()]);
        return Schedule::findOrFail($id);

        try {
            $schedule = Schedule::where(function ($query) {
                    $query->where('user1_id', Auth::id())
                          ->orWhere('user2_id', Auth::id());
                })
                ->find($id);

            if (!$schedule) {
                return response()->json(['message' => 'Schedule not found.'], 404);
            }

            return response()->json([
                'message' => 'Schedule fetched successfully.',
                'data' => $schedule
            ], 200);
        } catch (\Exception $e) {
            Log::error('API Schedule Show Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'schedule_id' => $id,
            ]);
            return response()->json(['message' => 'Failed to fetch schedule.'], 500);
        }
    }

    // public function show($id)
    // {
    //     $schedule = Schedule::findOrFail($id);
    //     return response()->json($schedule);
    // }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $schedule = Schedule::where(function ($query) {
    //                 $query->where('user1_id', Auth::id())
    //                       ->orWhere('user2_id', Auth::id());
    //             })
    //             ->find($id);

    //         if (!$schedule) {
    //             return response()->json(['message' => 'Schedule not found.'], 404);
    //         }

    //         $request->validate([
    //             'scheduled_at' => 'required|date|after:now',
    //             'method' => 'required|in:online,offline',
    //             'notes' => 'nullable|string',
    //             'status' => 'required|in:upcoming,completed,cancelled',
    //         ]);

    //         $schedule->update([
    //             'scheduled_at' => $request->scheduled_at,
    //             'method' => $request->method,
    //             'notes' => $request->notes,
    //             'status' => $request->status,
    //         ]);

    //         return response()->json([
    //             'message' => 'Schedule updated successfully!',
    //             'data' => $schedule
    //         ], 200);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Validation failed.',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (\Exception $e) {
    //         Log::error('API Schedule Update Error: ' . $e->getMessage(), [
    //             'user_id' => Auth::id(),
    //             'schedule_id' => $id,
    //         ]);
    //         return response()->json(['message' => 'Failed to update schedule.'], 500);
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $schedule = Schedule::where(function ($query) {
    //                 $query->where('user1_id', Auth::id())
    //                       ->orWhere('user2_id', Auth::id());
    //             })
    //             ->find($id);

    //         if (!$schedule) {
    //             return response()->json(['message' => 'Schedule not found.'], 404);
    //         }

    //         $schedule->delete();

    //         return response()->json(['message' => 'Schedule deleted successfully.'], 200);
    //     } catch (\Exception $e) {
    //         Log::error('API Schedule Delete Error: ' . $e->getMessage(), [
    //             'user_id' => Auth::id(),
    //             'schedule_id' => $id,
    //         ]);
    //         return response()->json(['message' => 'Failed to delete schedule.'], 500);
    //     }
    // }
=======
        if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized to view this schedule.'], 403);
        }

        try {
            $schedule->load(['user1', 'user2']);
            return response()->json($schedule);
        } catch (\Exception $e) {
            Log::error('Error in ScheduleApiController@show: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to retrieve schedule details.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Schedule $schedule)
    {
        if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized to update this schedule.'], 403);
        }

        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'method' => 'required|in:online,offline',
            'notes' => 'nullable|string',
            'status' => 'required|in:upcoming,completed,cancelled',
        ]);

        try {
            $schedule->update([
                'scheduled_at' => $request->scheduled_at,
                'method' => $request->method,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Schedule updated successfully!', 'schedule' => $schedule]);
        } catch (\Exception $e) {
            Log::error('Error in ScheduleApiController@update: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to update schedule.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized to delete this schedule.'], 403);
        }

        try {
            $schedule->delete();
            return response()->json(['message' => 'Schedule deleted successfully!'], 204); 
        } catch (\Exception $e) {
            Log::error('Error in ScheduleApiController@destroy: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to delete schedule.', 'error' => $e->getMessage()], 500);
        }
    }
>>>>>>> Stashed changes
}