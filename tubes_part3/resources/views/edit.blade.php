@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Schedule</h2>
    
    <form action="{{ route('schedule.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2">Tanggal & Waktu:</label>
        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $schedule->scheduled_at->format('Y-m-d\TH:i')) }}" class="w-full border p-2 mb-4">

        <label class="block mb-2">Metode:</label>
        <select name="method" class="w-full border p-2 mb-4">
            <option value="online" {{ old('method', $schedule->method) == 'online' ? 'selected' : '' }}>Online</option>
            <option value="offline" {{ old('method', $schedule->method) == 'offline' ? 'selected' : '' }}>Offline</option>
        </select>

        <label class="block mb-2">Catatan:</label>
        <textarea name="notes" class="w-full border p-2 mb-4">{{ old('notes', $schedule->notes) }}</textarea>

        <label class="block mb-2">Status:</label>
        <select name="status" class="w-full border p-2 mb-4">
            <option value="upcoming" {{ old('status', $schedule->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="completed" {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
