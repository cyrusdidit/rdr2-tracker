<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/toggle/{id}', [DashboardController::class, 'toggle']);
    Route::post('/reset', [DashboardController::class, 'reset']);
    
    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings/update-profile', [SettingsController::class, 'updateProfile'])->name('update-profile');
    Route::post('/settings/update-password', [SettingsController::class, 'updatePassword'])->name('update-password');
});