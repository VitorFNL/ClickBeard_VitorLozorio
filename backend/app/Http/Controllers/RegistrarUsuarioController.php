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
            $input = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios',
                'senha' => 'required|string|min:8',
                'admin' => 'sometimes|boolean',
            ]);

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
