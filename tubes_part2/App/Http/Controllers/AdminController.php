<?php

namespace App\Http\Controllers; // Pastikan namespace ini benar

use Illuminate\Http\Request;
use App\Models\User;      // Import model User
use App\Models\Post;      // Import model Post
use App\Models\Portfolio; // Import model Portfolio
use App\Models\Skill;     // Import model Skill (jika digunakan)

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik.
     */
    public function index()
    {
        // Mengambil statistik
        $totalUsers = User::count();
        $totalOpenPosts = Post::where('type', 'open')->count();
        $totalNeedHelpPosts = Post::where('type', 'need')->count();
        $totalPortfolioItems = Portfolio::count();

        // Mengambil aktivitas terbaru (misalnya 3 item terakhir)
        $latestPosts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $latestUsers = User::orderBy('created_at', 'desc')->take(3)->get();
        $latestPortfolios = Portfolio::orderBy('created_at', 'desc')->take(3)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOpenPosts',
            'totalNeedHelpPosts',
            'totalPortfolioItems',
            'latestPosts',
            'latestUsers',
            'latestPortfolios'
        ));
    }

    /**
     * Menampilkan halaman manajemen pengguna.
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Menampilkan halaman manajemen postingan.
     */
    public function posts()
    {
        $posts = Post::all();
        return view('admin.posts', compact('posts'));
    }

    /**
     * Menampilkan halaman manajemen skill.
     */
    public function skills()
    {
        $skills = Skill::all();
        return view('admin.skills', compact('skills'));
    }
}