<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('/login');
});
Route::view('/registro', 'register')->name('register'); // vista Registro
Route::view('/login', 'login')->name('login');   // vista Inicio de sesión

// ✅ SOLUCIÓN TEMPORAL: Mantener JWT middleware con bypass
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, '__invoke'])->name('dashboard');
    
    // Rutas web para CRUD de proyectos
    Route::resource('projects', ProjectController::class);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
