<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;// hash para la contraseña
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // POST /api/register
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');

        $validator = Validator::make($data, [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // aqui esta el hash 
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'ok' => true,
            'message' => 'Usuario registrado correctamente.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token
        ], 201)->cookie('jwt_token', $token, 60, '/', null, false, true); // HttpOnly (Secure solo en producción)
    }

    // POST /api/login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'ok' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        return response()->json([
            'ok' => true,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ])->cookie('jwt_token', $token, 60, '/', null, false, true); // HttpOnly (Secure solo en producción)
    }

    // GET /api/me
    public function me()
    {
        return response()->json([
            'ok' => true,
            'user' => auth('api')->user()
        ]);
    }
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Sesión cerrada correctamente.'])
            ->cookie('jwt_token', '', -1); // Eliminar cookie
    }
}

