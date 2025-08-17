<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Intentar obtener token desde diferentes fuentes
            $token = $request->bearerToken(); // Header Authorization
            
            if (!$token && $request->cookie('jwt_token')) {
                $token = $request->cookie('jwt_token');
            }
            
            if (!$token && $request->query('token')) {
                $token = $request->query('token');
            }
            
            if (!$token && $request->session()->has('jwt_token')) {
                $token = $request->session()->get('jwt_token');
            }
            
            if (!$token) {
                return response()->json(['status' => false, 'message' => 'Token no proporcionado'], 401);
            }
            
            // Establecer el token para JWTAuth
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
            
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Usuario no encontrado'], 404);
            }
            
        } catch (TokenExpiredException $e) {
            // Opción de renovación automática (mejor práctica)
            try {
                $refreshedToken = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshedToken)->toUser();
                
                // Agregar usuario a la solicitud
                $request->auth = $user;
                
                // Devolver token renovado en la respuesta
                $response = $next($request);
                return $response->header('Authorization', 'Bearer ' . $refreshedToken);
            } catch (JWTException $e) {
                return response()->json(['status' => false, 'message' => 'Token expirado'], 401);
            }
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => false, 'message' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'message' => 'Token no proporcionado'], 401);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error de autenticación', 'error' => $e->getMessage()], 500);
        }

        return $next($request);
    }
}
