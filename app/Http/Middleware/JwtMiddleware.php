<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Intenta autenticar por token
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['ok' => false, 'message' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['ok' => false, 'message' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            return response()->json(['ok' => false, 'message' => 'Token no provisto'], 401);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => 'No autorizado'], 401);
        }

        return $next($request);
    }
}
