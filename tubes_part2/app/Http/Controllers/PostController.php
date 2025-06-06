<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:open,need',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'preference' => 'required|in:online,offline,both',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'preference' => $request->preference,
        ]);

        $post->skills()->attach($request->skills);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    public function update(Request $request, Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:open,need',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'preference' => 'required|in:online,offline,both',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ]);

        $post->update([
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'preference' => $request->preference,
        ]);

        $post->skills()->sync($request->skills);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
}