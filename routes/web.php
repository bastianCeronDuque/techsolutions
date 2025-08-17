<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('/login');
});
Route::view('/registro', 'register')->name('register'); // vista Registro
Route::view('/login', 'login')->name('login');   // vista Inicio de sesión

Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, '__invoke'])->name('dashboard');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
