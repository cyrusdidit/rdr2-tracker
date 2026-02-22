<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::post('/toggle/{id}', [DashboardController::class, 'toggle']);