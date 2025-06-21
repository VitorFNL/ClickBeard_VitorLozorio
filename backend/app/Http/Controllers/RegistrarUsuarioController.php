<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarUsuarioRequest;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInput;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInterface;
use Illuminate\Http\Request;

class RegistrarUsuarioController extends Controller
{
    public function __construct(
        private RegistrarUsuarioInterface $registrarUsuario,
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->all();

            $input_valido = RegistrarUsuarioRequest::validate($input);

            if (!$input_valido) {
                return response()->json([
                    'error'=> 'Dados inválidos',
                    ],400);
            }


            $response = $this->registrarUsuario->execute(new RegistrarUsuarioInput(
                $input['nome'],
                $input['email'],
                $input['senha'],
                $input['admin'] ?? false,
            ));

            return response()->json([
                'status'=> 'success',
                'message'=> 'Usuário criado com sucesso',
                'nome'=> $response->nome
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error'=> $e->getMessage() ?: 'Erro interno do servidor',
                ], 500);
        }
    }
}
