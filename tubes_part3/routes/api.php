<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\WarningController;
<<<<<<< Updated upstream
use App\Http\Controllers\Api\ScheduleApiController;
use Illuminate\Support\Facades\Auth;

// login dan register
Route::get('/register', [AuthApiController::class, 'showregister']);
Route::get('/login', [AuthApiController::class, 'showLogin']);
=======
use App\Http\Controllers\Api\ScheduleApiController; // Tetap diimport jika ada controller lain yang masih membutuhkannya di api.php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// =========================================================================
// Public API Routes (No authentication required)
// =========================================================================

>>>>>>> Stashed changes
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

<<<<<<< Updated upstream
// buat post
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);
=======
// Endpoint API untuk form login/register (jika memang mengembalikan JSON, bukan HTML)
Route::get('/register-form', [AuthApiController::class, 'showregister']);
Route::get('/login-form', [AuthApiController::class, 'showLogin']);

// Resource API publik untuk operasi GET (index dan show)
Route::apiResource('posts', PostApiController::class)->only(['index', 'show']);
// Pastikan ini hanya ada satu kali, jika Anda tidak ingin portfolio publik, hapus ini.
Route::apiResource('portfolios', PortfolioApiController::class)->only(['index', 'show']);


// =========================================================================
// Protected API Routes (Requires Laravel Sanctum Authentication)
// =========================================================================
>>>>>>> Stashed changes

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostApiController::class, 'store']);
 
    Route::post('/portfolios', [PortfolioApiController::class, 'store']);

<<<<<<< Updated upstream
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
});

// buat portfolio
Route::middleware('web')->apiResource('portfolios', PortfolioApiController::class);

Route::get('/portfolios', [PortfolioApiController::class, 'index']);
Route::get('/portfolios/{id}', [PortfolioApiController::class, 'show']);

// buat schedule
// routes/web.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('schedules', ScheduleApiController::class);
});

// buat warning
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('warnings', WarningController::class);
});

// ambil data user dari api
Route::get('/user', function (Request $request) {
        return $request->user();
});
=======
    // Otentikasi terkait (setelah login)
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Resource API yang memerlukan autentikasi untuk operasi CRUD (atau yang tersisa)
    Route::apiResource('posts', PostApiController::class)->except(['index', 'show']);
    Route::apiResource('portfolios', PortfolioApiController::class)->except(['index', 'show']);

    // Rute Schedules Dihapus dari sini karena sudah dipindahkan ke routes/web.php
    // Route::apiResource('schedules', ScheduleApiController::class); // HAPUS INI
    // Route::get('/schedules', [ScheduleApiController::class, 'index']); // HAPUS INI
    // Route::post('/schedules', [ScheduleApiController::class, 'store']); // HAPUS INI
    // Route::get('/schedules/{id}', [ScheduleApiController::class, 'show']); // HAPUS INI
    // Route::put('/schedules/{id}', [ScheduleApiController::class, 'update']); // HAPUS INI
    // Route::delete('/schedules/{id}', 'ScheduleApiController::destroy'); // HAPUS INI


    // Rute untuk Profile (jika profile API juga diakses dari luar web app)
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);

    // API Warnings (Tetap di sini jika warning API juga diakses dari luar web app)
    Route::apiResource('warnings', WarningController::class);
});
>>>>>>> Stashed changes
