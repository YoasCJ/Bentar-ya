<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\WarningController;
use App\Http\Controllers\Api\ScheduleApiController;

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
// Ini adalah rute yang bisa diakses oleh siapa saja tanpa login.
// Contoh: untuk proses login/registrasi dari aplikasi client (mobile/SPA).
// =========================================================================

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// Jika 'showregister' dan 'showLogin' seharusnya menampilkan FORM HTML,
// mereka TIDAK seharusnya berada di routes/api.php.
// Routes untuk form HTML harus ada di routes/web.php.
// Saya akan mengasumsikan ini adalah endpoint API yang mungkin mengembalikan JSON.
Route::get('/register-form', [AuthApiController::class, 'showregister']); // Diubah namanya agar tidak ambigu jika memang endpoint API
Route::get('/login-form', [AuthApiController::class, 'showLogin']);     // Diubah namanya agar tidak ambigu jika memang endpoint API


// Resource API publik untuk operasi GET (index dan show)
// Misalnya, untuk melihat daftar postingan atau portfolio tanpa login.
Route::apiResource('posts', PostApiController::class)->only(['index', 'show']);
Route::apiResource('portfolios', PortfolioApiController::class)->only(['index', 'show']);


// =========================================================================
// Protected API Routes (Requires Laravel Sanctum Authentication)
// Rute di grup ini memerlukan token autentikasi (misalnya Bearer Token)
// yang dikirimkan bersama setiap request dari client.
// =========================================================================

Route::middleware('auth:sanctum')->group(function () {

    // Otentikasi terkait (setelah login)
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', function (Request $request) { // Mendapatkan detail user yang terautentikasi
        return $request->user();
    });

    // Resource API yang memerlukan autentikasi untuk semua operasi CRUD (atau yang tersisa)
    // apiResource secara otomatis mendaftarkan: index, store, show, update, destroy.
    // Jika 'index' dan 'show' sudah diizinkan publik, gunakan 'except' untuk menghindari duplikasi.
    Route::apiResource('posts', PostApiController::class)->except(['index', 'show']); // Untuk POST, PUT/PATCH, DELETE
    Route::apiResource('portfolios', PortfolioApiController::class)->except(['index', 'show']); // Untuk POST, PUT/PATCH, DELETE
    Route::apiResource('schedules', ScheduleApiController::class); // Semua operasi: GET (index, show), POST, PUT/PATCH, DELETE
    Route::apiResource('warnings', WarningController::class); // Semua operasi: GET (index, show), POST, PUT/PATCH, DELETE

    // Rute spesifik yang terautentikasi (jika tidak tercakup oleh apiResource)
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
});