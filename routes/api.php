<?php
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/prueba', function () {
    return response()->json(['mensaje' => 'API funcionando ✅']);
});
// Rutas protegidas con JWT
Route::middleware('jwt')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
});
Route::middleware('auth:api')->get('/usuario-autenticado', function (Request $request) {
    return response()->json([
        'ok' => true,
        'user' => $request->user()
    ]);
});
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

