<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ProfileApiController;

// Auth (tidak perlu token)
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

// Route yang tidak perlu login (GET publik)
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);
Route::get('/portfolios', [PortfolioApiController::class, 'index']);
Route::get('/portfolios/{id}', [PortfolioApiController::class, 'show']);

// Route yang memerlukan login/token
Route::middleware('auth:sanctum')->group(function () {
    // Post bantuan (buat)
    Route::post('/posts', [PostApiController::class, 'store']);

    // Portfolio (buat)
    Route::post('/portfolios', [PortfolioApiController::class, 'store']);

    // Profile
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
});
