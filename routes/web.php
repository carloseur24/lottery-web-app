<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\usuarioController;
use App\Http\Middleware\authmiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard')->middleware(authmiddleware::class);
Route::get('/login', [authController::class, 'login']);
Route::post('/login', [authController::class, 'authenticate']);
Route::get('/register', [authController::class, 'register']);
Route::post('/payment/pago-movil/validate', [paymentController::class, 'pago_movil'])->name('payment.pago-movil.validate')->middleware(authmiddleware::class);
Route::post('/perfil/usuario/logout', [authController::class, 'logout'])->name('perfil_usuario.logout')->middleware(authmiddleware::class);
Route::post('/perfil/usuario/update', [usuarioController::class, 'updateUserData'])->name('perfil_usuario.update')->middleware(authmiddleware::class);
Route::get('/perfil/usuario', [usuarioController::class, 'getUserData'])->name('perfil_usuario.all')->middleware(authmiddleware::class);
Route::post('/perfil/usuario', [usuarioController::class, 'getUserDataById'])->name('perfil_usuario.id')->middleware(authmiddleware::class);
Route::post('/register', [authController::class, 'store']);
