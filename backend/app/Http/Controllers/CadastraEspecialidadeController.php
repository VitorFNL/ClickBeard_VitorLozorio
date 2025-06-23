<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\CadastraEspecialidade\CadastraEspecialidadeInput;
use App\UseCases\CadastraEspecialidade\CadastraEspecialidadeInterface;
use Illuminate\Http\Request;

class CadastraEspecialidadeController extends Controller
{

    public function __construct(
        private CadastraEspecialidadeInterface $cadastraEspecialidade
    ) {}    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'descricao' => 'required|string|max:255|unique:especialidades,descricao',
            ]);

            $response = $this->cadastraEspecialidade->execute(
                new CadastraEspecialidadeInput(
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
