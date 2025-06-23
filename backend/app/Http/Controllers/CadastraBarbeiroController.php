<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\CadastraBarbeiro\CadastraBarbeiroInput;
use App\UseCases\CadastraBarbeiro\CadastraBarbeiroInterface;
use Illuminate\Http\Request;

class CadastraBarbeiroController extends Controller
{

    public function __construct(
        private CadastraBarbeiroInterface $cadastraBarbeiro
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'data_contratacao' => 'required|date_format:Y-m-d',
            ]);

            $response = $this->cadastraBarbeiro->execute(
                new CadastraBarbeiroInput(
                    $request['nome'],
                    $request['data_nascimento'],
                    $request['data_contratacao']
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
