<?php

use App\Models\User;
use App\Http\Controllers\Auth\AuthController;
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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Hapus rute duplikat ini, karena sudah ada di dalam grup middleware('auth') di bawah.
// Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');
// Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit')->middleware('auth');
// Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update')->middleware('auth');
// Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy')->middleware('auth');


// Protected routes (for regular authenticated users)
Route::middleware('auth')->group(function () {
    // Dashboard User Biasa
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
    Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::get('/schedule/{schedule}/json', [ScheduleController::class, 'json'])->name('schedule.json');



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
    Route::get('/portfolio/{portfolio}/json', [PortfolioController::class, 'json'])->name('portfolio.json');
    Route::get('/portfolio/{portfolio}/json', [PortfolioController::class, 'json'])->name('portfolio.json');
});

// ======================================================================================================
// Rute untuk Dashboard Admin dan Manajemen Admin
// ======================================================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    // URI: /admin/dashboard, Nama: admin.dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen User
    // URI: /admin/users, Nama: admin.users.index
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    // URI: /admin/users/{user}, Nama: admin.users.destroy
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Manajemen Posts (Pastikan ini rute yang benar untuk admin, bukan duplikat dengan posts user biasa)
    // URI: /admin/posts, Nama: admin.posts.index
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    // URI: /admin/posts/{post}, Nama: admin.posts.destroy
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');

    // Manajemen Portfolio
    // URI: /admin/portfolios, Nama: admin.portfolios.index
    Route::get('/portfolios', [AdminController::class, 'portfolios'])->name('portfolios.index');
    // URI: /admin/portfolios/{portfolio}, Nama: admin.portfolios.destroy
    Route::delete('/portfolios/{portfolio}', [AdminController::class, 'destroyPortfolio'])->name('portfolios.destroy');

    // Manajemen Peringatan
    // URI: /admin/warnings, Nama: admin.warnings.index
    Route::get('/warnings', [AdminController::class, 'warnings'])->name('warnings.index');
    // URI: /admin/warnings/create, Nama: admin.warnings.create
    Route::get('/warnings/create', [AdminController::class, 'createWarningForm'])->name('warnings.create');
    // URI: /admin/warnings/store, Nama: admin.warnings.store
    Route::post('/warnings/store', [AdminController::class, 'storeWarning'])->name('warnings.store');
    // URI: /admin/warnings/{warning}/edit, Nama: admin.warnings.edit
    Route::get('/warnings/{warning}/edit', [AdminController::class, 'editWarning'])->name('warnings.edit');
    // URI: /admin/warnings/{warning}, Nama: admin.warnings.update
    Route::put('/warnings/{warning}', [AdminController::class, 'updateWarning'])->name('warnings.update');
    // URI: /admin/warnings/{warning}, Nama: admin.warnings.destroy
    Route::delete('/warnings/{warning}', [AdminController::class, 'destroyWarning'])->name('warnings.destroy');
});