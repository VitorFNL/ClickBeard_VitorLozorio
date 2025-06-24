<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\UseCases\Login\LoginInput;
use App\UseCases\Login\LoginInterface;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct(
        private LoginInterface $login,
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'email' => 'required|string|email|max:255',
                'senha' => 'required|string|min:8',
            ]);


            $response = $this->login->execute(new LoginInput(
                $input['email'],
                $input['senha']
            ));

            $jsonResponse = response()->json([
                'status'=> 'success',
                'message'=> 'Usuário logado com sucesso',
                'token'=> $response->token,
                'usuario' => $response->usuario,
            ], 200);

            $jsonResponse->cookie(
                'jwt_token',
                $response->token,
                60,
                '/',
                null,
                config('app.env') === 'production',
                true,
                false,
                'Lax'
            );

            return $jsonResponse;

        } catch (\Exception $e) {
            return response()->json([
                'error'=> $e->getMessage() ?: 'Erro interno do servidor',
                ], $e->getCode() ?: 500);
        }
    }
}
