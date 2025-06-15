<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;

use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\Api\WarningController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================
// ROUTE UNTUK USER BIASA
// ==========================
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
    Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
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

    // API Resource (jika kamu memang butuh untuk keperluan API terpisah)
    Route::resource('api/schedules', ScheduleApiController::class)->except(['create', 'edit']);
    Route::resource('api/portfolios', PortfolioApiController::class)->except(['create', 'edit']);
    Route::resource('api/warnings', WarningController::class)->except(['create', 'edit']);
});

// ==========================
// ROUTE UNTUK ADMIN
// ==========================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Posts
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');

    // Portfolios
    Route::get('/portfolios', [AdminController::class, 'portfolios'])->name('portfolios.index');
    Route::delete('/portfolios/{portfolio}', [AdminController::class, 'destroyPortfolio'])->name('portfolios.destroy');

    // Warnings
    Route::get('/warnings', [AdminController::class, 'warnings'])->name('warnings.index');
    Route::get('/warnings/create', [AdminController::class, 'createWarningForm'])->name('warnings.create');
    Route::post('/warnings/store', [AdminController::class, 'storeWarning'])->name('warnings.store');
    Route::get('/warnings/{warning}/edit', [AdminController::class, 'editWarning'])->name('warnings.edit');
    Route::put('/warnings/{warning}', [AdminController::class, 'updateWarning'])->name('warnings.update');
    Route::delete('/warnings/{warning}', [AdminController::class, 'destroyWarning'])->name('warnings.destroy');
});
