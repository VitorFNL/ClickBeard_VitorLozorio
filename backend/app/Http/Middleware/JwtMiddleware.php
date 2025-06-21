<?php

namespace App\Http\Middleware;

use App\Infrastructure\Persistence\Mappers\UsuarioMapper;
use App\Services\JwtService;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

class JwtMiddleware
{

    public function __construct(
        private JwtService $jwtService
    )
    {}

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token && $request->hasCookie('jwt_token')) {
            $token = $request->cookie('jwt_token');
        }

        if (!$token) {
            return response()->json([
                'error' => 'Token não fornecido',
            ], 401);
        }

        try {
            $credentials = $this->jwtService->decodeToken($token);

            if (!isset($credentials->sub) || !isset($credentials->user_data)) {
                return response()->json([
                    'message' => 'Token inválido: dados essenciais ausentes no payload.'
                ], 401);
            }

            $userFromToken = UsuarioMapper::fromJwtPayload($credentials->user_data);

            $request->user = $userFromToken;

        } catch (ExpiredException $e) {
            return response()->json(['message' => 'Token expirado. Por favor, faça login novamente.'], 401);
        } catch (SignatureInvalidException | UnexpectedValueException $e) {
            return response()->json(['message' => 'Assinatura ou formato do token inválido: ' . $e->getMessage()], 401);
        } catch (RuntimeException $e) {
            return response()->json(['message' => 'Erro interno de configuração do JWT: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno inesperado ao validar token.'], 500);
        }

        return $next($request);
    }
}
