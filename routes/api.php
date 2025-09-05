<?php
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/prueba', function () {
    return response()->json(['mensaje' => 'API funcionando ✅']);
});

// Todas las rutas protegidas bajo un solo middleware JWT
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/usuario-autenticado', function (Request $request) {
        return response()->json([
            'ok' => true,
            'user' => $request->user()
        ]);
    });

    // Rutas de proyectos
    Route::apiResource('projects', ProjectController::class);
});

