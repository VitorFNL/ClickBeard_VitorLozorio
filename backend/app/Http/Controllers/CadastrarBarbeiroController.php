<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\CadastrarBarbeiro\CadastrarBarbeiroInput;
use App\UseCases\CadastrarBarbeiro\CadastrarBarbeiroInterface;
use Illuminate\Http\Request;

class CadastrarBarbeiroController extends Controller
{

    public function __construct(
        private CadastrarBarbeiroInterface $cadastrarBarbeiro
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'data_contratacao' => 'required|date_format:Y-m-d',
            ]);

            $response = $this->cadastrarBarbeiro->execute(
                new CadastrarBarbeiroInput(
                    $input['nome'],
                    $input['data_nascimento'],
                    $input['data_contratacao']
                )
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Barbeiro cadastrado com sucesso',
                'barbeiro' => [
                    'id' => $response->id,
                    'nome' => $response->nome,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
