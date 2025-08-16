<?php

use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
Route::get('/', function () {
    return view('/login');
});
Route::view('/registro', 'register'); // vista Registro
Route::view('/login', 'login');       // vista Inicio de sesión
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, '__invoke'])->name('dashboard');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
