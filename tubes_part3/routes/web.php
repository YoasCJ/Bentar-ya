<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ScheduleController; // <-- Pastikan ini di-import
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ScheduleApiController;
use Illuminate\Support\Facades\Route;
// Import ScheduleApiController juga jika Anda ingin menggunakan class tersebut di web.php
use App\Http\Controllers\Api\ScheduleApiController; // <-- Pastikan ini di-import

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute untuk login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk registrasi
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk logout (harus POST dan dilindungi oleh middleware 'auth')
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

<<<<<<< Updated upstream
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

// Route untuk menampilkan form edit jadwal (jika bukan modal murni)
Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit')->middleware('auth');

// Route untuk update jadwal (metode PUT/PATCH)
Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update')->middleware('auth');

// Route untuk delete jadwal
Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy')->middleware('auth');

Route::get('/api/schedules/{id}', [ScheduleApiController::class, 'show'])->middleware('auth');

Route::middleware(['auth'])->get('/api/schedules/{id}', [ScheduleApiController::class, 'show']);

// Protected routes
=======
// Protected routes (for regular authenticated users - web guard)
>>>>>>> Stashed changes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
<<<<<<< Updated upstream
    
    // Schedule
=======

    // Schedule (Menggunakan ScheduleController untuk operasi dasar)
    // Ini adalah rute HTML untuk halaman schedule
>>>>>>> Stashed changes
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
<<<<<<< Updated upstream
    
=======
    Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');

    // =========================================================================
    // API Routes for Schedules (using ScheduleApiController, protected by web guard)
    // Ini adalah endpoint API yang akan dipanggil oleh JavaScript dari frontend web
    // Menggunakan 'api' prefix agar URL-nya tetap konsisten (misal: /api/schedules/1)
    // =========================================================================
    Route::prefix('api')->group(function () {
        // Menggunakan apiResource untuk mendaftarkan semua operasi CRUD API
        // Karena ini di dalam grup middleware 'auth' (web guard), otentikasi akan otomatis via sesi.
        Route::apiResource('schedules', ScheduleApiController::class);
    });
    // =========================================================================


>>>>>>> Stashed changes
    // Profile
    Route::get('/profile/{user?}', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Portfolio
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
});     

<<<<<<< Updated upstream
// Rute khusus untuk Dashboard Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // manajemen user
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // manajemen posts
    // Route::get('/posts', [AdminController::class, 'posts'])->name('admin.posts.index');
    // Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('admin.posts.destroy');
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');

    // manajemen portfolio
    Route::get('/portfolios', [AdminController::class, 'portfolios'])->name('admin.portfolios.index');
    Route::delete('/portfolios/{portfolio}', [AdminController::class, 'destroyPortfolio'])->name('admin.portfolios.destroy'); 

    // manajemen peringatan
    Route::get('/warnings', [AdminController::class, 'warnings'])->name('admin.warnings.index');
    Route::get('/warnings/create', [AdminController::class, 'createWarningForm'])->name('admin.warnings.create');
    Route::post('/warnings/store',[AdminController::class, 'storeWarning'])->name('admin.warnings.store');
    Route::get('/warnings/{warning}/edit', [AdminController::class, 'editWarning'])->name('admin.warnings.edit');
    Route::put('/warnings/{warning}', [AdminController::class, 'updateWarning'])->name('admin.warnings.update');
    Route::delete('/warnings/{warning}', [AdminController::class, 'destroyWarning'])->name('admin.warnings.destroy');
});
=======

// ======================================================================================================
// Rute untuk Dashboard Admin dan Manajemen Admin
// ======================================================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen User
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Manajemen Posts
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');

    // Manajemen Portfolio
    Route::get('/portfolios', [AdminController::class, 'portfolios'])->name('portfolios.index');
    Route::delete('/portfolios/{portfolio}', [AdminController::class, 'destroyPortfolio'])->name('portfolios.destroy');

    // Manajemen Peringatan
    Route::get('/warnings', [AdminController::class, 'warnings'])->name('warnings.index');
    Route::get('/warnings/create', [AdminController::class, 'createWarningForm'])->name('warnings.create');
    Route::post('/warnings/store', [AdminController::class, 'storeWarning'])->name('warnings.store');
    Route::get('/warnings/{warning}/edit', [AdminController::class, 'editWarning'])->name('warnings.edit');
    Route::put('/warnings/{warning}', [AdminController::class, 'updateWarning'])->name('warnings.update');
    Route::delete('/warnings/{warning}', [AdminController::class, 'destroyWarning'])->name('warnings.destroy');
});
>>>>>>> Stashed changes
