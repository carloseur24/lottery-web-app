<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use App\Http\Middleware\authmiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard')->middleware(authmiddleware::class);
Route::get('/login', [authController::class, 'login']);
Route::post('/login', [authController::class, 'authenticate']);
Route::get('/register', [authController::class, 'register']);
Route::post('/register', [authController::class, 'store']);
