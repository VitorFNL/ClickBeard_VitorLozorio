<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUserMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $requestUser = $request->user;

        if (!$requestUser) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        if (!$requestUser->admin) {
            return response()->json(['message' => 'Acesso negado'], 403);
        }

        return $next($request);
    }
}
