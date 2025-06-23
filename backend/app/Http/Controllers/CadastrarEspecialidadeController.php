<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\CadastrarEspecialidade\CadastrarEspecialidadeInput;
use App\UseCases\CadastrarEspecialidade\CadastrarEspecialidadeInterface;
use Illuminate\Http\Request;

class CadastrarEspecialidadeController extends Controller
{

    public function __construct(
        private CadastrarEspecialidadeInterface $cadastrarEspecialidade
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'descricao' => 'required|string|max:255|unique:especialidades,descricao',
            ]);

            $response = $this->cadastrarEspecialidade->execute(
                new CadastrarEspecialidadeInput(
                    $input['descricao']
                )
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Especialidade cadastrada com sucesso',
                'especialidade' => [
                    'id' => $response->id,
                    'descricao' => $response->descricao,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
