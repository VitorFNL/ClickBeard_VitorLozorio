<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\VinculaEspecialidadesBarbeiro\VinculaEspecialidadesBarbeiroInput;
use App\UseCases\VinculaEspecialidadesBarbeiro\VinculaEspecialidadesBarbeiroInterface;
use Illuminate\Http\Request;

class VinculaEspecialidadesBarbeiroController extends Controller
{
    
    public function __construct(
        private VinculaEspecialidadesBarbeiroInterface $vinculaEspecialidadesBarbeiro
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'barbeiro_id' => 'required|exists:barbeiros,barbeiro_id',
                'especialidades' => 'required|array',
                'especialidades.*' => 'exists:especialidades,especialidade_id',
            ]);

            $response = $this->vinculaEspecialidadesBarbeiro->execute(
                new VinculaEspecialidadesBarbeiroInput(
                    $input['barbeiro_id'],
                    $input['especialidades']
                )
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Especialidades vinculadas com sucesso',
                'barbeiro' => [
                    'id' => $response->barbeiroId,
                    'especialidades' => $response->especialidades,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
