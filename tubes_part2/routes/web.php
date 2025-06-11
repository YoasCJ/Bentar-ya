<?php
use App\Models\User; 
use App\Models\Post; 
use App\Models\Portfolio;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/register', [AuthApiController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthApiController::class, 'register']);
Route::get('/login', [AuthApiController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Schedule
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    
    // Profile
    Route::get('/profile/{user?}', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Portfolio
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::put('/portfolio/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
});     

// Rute khusus untuk Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); // Membuka file tampilan yang baru saja kita buat
})->middleware('role:admin')->name('admin.dashboard');

Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    // --- Modifikasi Rute Dashboard Admin di Sini ---
    Route::get('/dashboard', function () {
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
    })->name('admin.dashboard');

    // ... (rute-rute manajemen lainnya: admin.users, admin.posts, admin.skills) ...
    Route::get('/users', function () {
        $users = User::all();
        return view('admin.users', compact('users'));
    })->name('admin.users');

    Route::get('/posts', function () {
        $posts = Post::all();
        return view('admin.posts', compact('posts'));
    })->name('admin.posts');

    Route::get('/skills', function () {
        $skills = \App\Models\Skill::all(); // Perbaiki namespace ini jika perlu: App\Models\Skill
        return view('admin.skills', compact('skills'));
    })->name('admin.skills');

});
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    // Rute untuk dashboard admin utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rute untuk Manajemen Pengguna
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');

    // Rute untuk Manajemen Postingan
    Route::get('/posts', [AdminController::class, 'posts'])->name('admin.posts');

    // Rute untuk Manajemen Skill
    Route::get('/skills', [AdminController::class, 'skills'])->name('admin.skills');
});
