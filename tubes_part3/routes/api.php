<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\WarningController;

Route::get('/register', [AuthApiController::class, 'showregister']);
Route::get('/login', [AuthApiController::class, 'showLogin']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);

Route::middleware('web')->apiResource('portfolios', PortfolioApiController::class);

Route::get('/portfolios', [PortfolioApiController::class, 'index']);
Route::get('/portfolios/{id}', [PortfolioApiController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostApiController::class, 'store']);
 
    Route::post('/portfolios', [PortfolioApiController::class, 'store']);

    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('web')->apiResource('schedules', ScheduleApiController::class);

Route::middleware('web')->apiResource('portfolios', PortfolioApiController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('warnings', WarningController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->apiResource('schedules', ScheduleApiController::class);

Route::get('/schedules', [ScheduleApiController::class, 'index']); 
Route::post('/schedules', [ScheduleApiController::class, 'store']);
Route::get('/schedules/{id}', [ScheduleApiController::class, 'show']);
Route::put('/schedules/{id}', [ScheduleApiController::class, 'update']);
Route::delete('/schedules/{id}', [ScheduleApiController::class, 'destroy']);