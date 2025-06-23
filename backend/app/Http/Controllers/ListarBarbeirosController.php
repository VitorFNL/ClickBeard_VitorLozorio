<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\ListarBarbeiros\ListarBarbeirosInput;
use App\UseCases\ListarBarbeiros\ListarBarbeirosInterface;
use Illuminate\Http\Request;

class ListarBarbeirosController extends Controller
{
    
    public function __construct(
        private ListarBarbeirosInterface $listaBarbeiros
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'especialidade' => 'sometimes|exists:especialidades,especialidade_id',
                'data' => 'sometimes|date_format:Y-m-d',
                'hora' => 'sometimes|date_format:H:i',
            ]);

            $input['user'] = $request->user;

            $data = null;
            if (isset($input['data'])) {
                $data = new \DateTime($input['data']);
            }

            $hora = null;
            if (isset($input['hora'])) {
                $hora = new \DateTime($input['hora']);
            }

            $response = $this->listaBarbeiros->execute(new ListarBarbeirosInput(
                $input['user']->admin,
                $data,
                $hora,
                $input['especialidade'] ?? null,
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Barbeiros listados com sucesso',
                'barbeiros' => $response->barbeiros
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
