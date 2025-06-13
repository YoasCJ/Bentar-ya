<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('user1_id', Auth::id())
            ->orWhere('user2_id', Auth::id())
            ->with(['user1', 'user2'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        $users = User::where('id', '!=', Auth::id())->get();

        return view('schedule', compact('schedules', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user2_id' => 'required|exists:users,id|different:user1_id',
            'scheduled_at' => 'required|date|after:now',
            'method' => 'required|in:online,offline',
            'notes' => 'nullable|string',
        ]);

        Schedule::create([
            'user1_id' => Auth::id(),
            'user2_id' => $request->user2_id,
            'scheduled_at' => $request->scheduled_at,
            'method' => $request->method,
            'notes' => $request->notes,
        ]);

        return redirect()->route('schedule')->with('success', 'Schedule created successfully!');
    }

public function json(Schedule $schedule)
{
    if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    return response()->json([
        'id' => $schedule->id,
        'notes' => $schedule->notes,
        'status' => $schedule->status,
        'method' => $schedule->method,
        'scheduled_at' => $schedule->scheduled_at,
    ]);
}

    public function edit(Schedule $schedule)
{
    // Hanya user yang terlibat (user1 atau user2) yang bisa mengedit
    if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
        abort(403, 'Anda tidak diizinkan untuk mengedit jadwal ini.');
    }

    // Data user lain (opsional, bisa untuk dropdown jika kamu pakai)
    $users = User::where('id', '!=', Auth::id())->get();

    // Kirim data ke view schedule/edit.blade.php
    return view('edit', compact('schedule', 'users'));
}

public function update(Request $request, Schedule $schedule)
{
    // Hanya user yang terlibat yang bisa mengubah jadwal
    if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
        abort(403);
    }

    // Validasi input dari form
    $request->validate([
        'scheduled_at' => 'required|date|after:now',
        'method' => 'required|in:online,offline',
        'notes' => 'nullable|string',
        'status' => 'required|in:upcoming,completed,cancelled',
    ]);

    // Update data ke database
    $schedule->update([
        'scheduled_at' => $request->scheduled_at,
        'method' => $request->method,
        'notes' => $request->notes,
        'status' => $request->status,
    ]);

    return redirect()->route('schedule')->with('success', 'Schedule berhasil diperbarui!');
}


    public function destroy(Schedule $schedule)
    {
        // Check if user is part of the schedule
        if ($schedule->user1_id !== Auth::id() && $schedule->user2_id !== Auth::id()) {
            abort(403);
        }

        $schedule->delete();

        return redirect()->route('schedule')->with('success', 'Schedule deleted successfully!');
    }
}