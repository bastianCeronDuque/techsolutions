<?php

// use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/registro', 'register'); // vista Registro
Route::view('/login', 'login');       // vista Inicio de sesión