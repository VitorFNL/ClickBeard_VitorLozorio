<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarUsuarioRequest;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInput;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInterface;

class RegistrarUsuarioController extends Controller
{
    public function __construct(
        private RegistrarUsuarioInterface $registrarUsuario,
    ) {}

    public function __invoke(RegistrarUsuarioRequest $request)
    {
        $input = $request->validated();
        
        try {
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
                ],$e->getCode() ?: 500);
        }
    }
}
