<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;      
use App\Models\Post;      
use App\Models\Portfolio; 
use App\Models\Warning;

class AdminController extends Controller
{
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

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if (Auth::check() && Auth::user()->id === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        try {
            $user->delete(); // Hapus user dari database
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            \Log::error('Error deleting user: ' . $e->getMessage(), ['user_id' => $user->id]);
            return back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    public function posts()
    {
        $posts = Post::with('user')->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    public function destroyPost(Post $post)
    {
        try {
            $post->delete(); // Hapus postingan dari database
            return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            \Log::error('Error deleting post: ' . $e->getMessage(), ['post_id' => $post->id]);
            return back()->with('error', 'Gagal menghapus postingan: ' . $e->getMessage());
        }
    }

    public function portfolios()
    {
        $portfolios = Portfolio::with('portfolio')->latest()->paginate(20);
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function destroyPortfolio(Portfolio $portfolio)
    {
        try {
            $portfolio->delete(); // Hapus portfolio dari database
            return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            \Log::error('Error deleting portfolio: ' . $e->getMessage(), ['portfolio_id' => $portfolio->id]);
            return back()->with('error', 'Gagal menghapus portfolio: ' . $e->getMessage());
        }
    }

    public function warnings()
    {
        $warnings = Warning::with('warning')->latest()->paginate(20);
        return view('admin.warnings.index', compact('warnings'));
    }

    public function createWarningForm()
    {
        $users = User::orderBy('name')->get();
        return view('admin.warnings.create', compact('users'));
    }

}
