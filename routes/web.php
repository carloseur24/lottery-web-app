<?php

use App\Http\Controllers\authController;
use App\Http\Middleware\authmiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/login', [authController::class, 'login'])->name('login')->middleware(authmiddleware::class);
Route::post('/login', [authController::class, 'auth'])->name('login.auth')->middleware(authmiddleware::class);
Route::get('/register', [authController::class, 'register'])->name('register')->middleware(authmiddleware::class);
Route::post('/register', [authController::class, 'create'])->name('register.create')->middleware(authmiddleware::class);
