<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillExchangeController;

// Public routes (no authentication required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');    
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::get('/skills', [SkillExchangeController::class, 'getSkills']); // Get all available skills

// Protected routes (authentication required using Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // User Profile
    Route::get('/user', [ProfileController::class, 'show']); // Get authenticated user profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']); // Update profile (using POST for file upload)
    Route::delete('/profile', [ProfileController::class, 'destroy']); // Tambahkan: Delete authenticated user profile

    // Skill Exchange
    Route::get('/exchange/users', [SkillExchangeController::class, 'index']); // Get list of users for skill exchange
});