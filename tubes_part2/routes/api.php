<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ProfileApiController;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);
Route::get('/portfolios', [PortfolioApiController::class, 'index']);
Route::get('/portfolios/{id}', [PortfolioApiController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostApiController::class, 'store']);

    Route::post('/portfolios', [PortfolioApiController::class, 'store']);

    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
});
