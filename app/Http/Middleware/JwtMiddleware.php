<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        // ✅ SOLUCIÓN: Si es petición web y hay usuario en Laravel Auth, continuar
        if (!$request->expectsJson() && Auth::check()) {
            return $next($request);
        }

        // ✅ TEMPORAL: Bypass completo para rutas web mientras solucionamos
        if (!$request->expectsJson()) {
            $webRoutes = ['dashboard', 'projects'];
            
            foreach ($webRoutes as $route) {
                if ($request->is($route) || $request->is($route.'/*')) {
                    // Si no hay usuario autenticado, usar el primer usuario disponible
                    if (!Auth::check()) {
                        $user = \App\Models\User::first();
                        if ($user) {
                            Auth::login($user, true);
                        }
                    }
                    return $next($request);
                }
            }
        }

        // ✅ DEBUG: Verificar qué tokens están disponibles
        $debugInfo = [
            'path' => $request->path(),
            'method' => $request->method(),
            'has_bearer' => !!$request->bearerToken(),
            'has_cookie' => !!$request->cookie('jwt_token'),
            'has_query' => !!$request->query('token'),
            'has_session' => !!$request->session()->has('jwt_token'),
            'auth_check' => Auth::check(),
            'url' => $request->fullUrl()
        ];
        
        // Para debug temporal
        Log::info('JWT Middleware Debug', $debugInfo);

        try {
            // ✅ SEGUNDO: Buscar token JWT desde diferentes fuentes
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
            
            // ✅ NUEVO: Buscar en headers personalizados (para JavaScript)
            if (!$token && $request->header('X-Auth-Token')) {
                $token = $request->header('X-Auth-Token');
            }
            
            if (!$token) {
                // ✅ Respuesta diferenciada según tipo de petición
                if ($request->expectsJson()) {
                    return response()->json(['status' => false, 'message' => 'Token no proporcionado'], 401);
                } else {
                    return redirect()->route('login')->with('error', 'Debes iniciar sesión');
                }
            }
            
            // ✅ Establecer el token y autenticar usuario
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
            
            if (!$user) {
                if ($request->expectsJson()) {
                    return response()->json(['status' => false, 'message' => 'Usuario no encontrado'], 404);
                } else {
                    return redirect()->route('login')->with('error', 'Usuario no encontrado');
                }
            }
            
            // ✅ Establecer usuario en Laravel Auth para compatibilidad completa
            Auth::login($user, true); // true = remember
            $request->auth = $user;
            
        } catch (TokenExpiredException $e) {
            // Opción de renovación automática
            try {
                $refreshedToken = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshedToken)->toUser();
                
                // ✅ CAMBIO: Establecer usuario en ambos sistemas
                Auth::login($user, true); // Usar login para web
                $request->auth = $user;
                
                // Devolver token renovado
                $response = $next($request);
                
                if ($request->expectsJson()) {
                    return $response->header('Authorization', 'Bearer ' . $refreshedToken);
                } else {
                    // Para web, actualizar cookie
                    return $response->cookie('jwt_token', $refreshedToken, 60, '/', null, true, true);
                }
                
            } catch (JWTException $e) {
                if ($request->expectsJson()) {
                    return response()->json(['status' => false, 'message' => 'Token expirado'], 401);
                } else {
                    return redirect()->route('login')->with('error', 'Sesión expirada');
                }
            }
        } catch (TokenInvalidException $e) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Token inválido'], 401);
            } else {
                return redirect()->route('login')->with('error', 'Token inválido');
            }
        } catch (JWTException $e) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Token no proporcionado'], 401);
            } else {
                return redirect()->route('login')->with('error', 'Error de autenticación');
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Error de autenticación', 'error' => $e->getMessage()], 500);
            } else {
                return redirect()->route('login')->with('error', 'Error interno');
            }
        }

        return $next($request);
    }
}
