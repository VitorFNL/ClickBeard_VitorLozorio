<?php

namespace App\Http\Controllers;

use App\UseCases\ListaAgendamentos\ListaAgendamentosInput;
use App\UseCases\ListaAgendamentos\ListaAgendamentosInterface;
use Illuminate\Http\Request;

class ListaAgendamentosController extends Controller
{
    
    public function __construct(
        private ListaAgendamentosInterface $listaAgendamentos
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'data' => 'sometimes|date_format:Y-m-d',
                'barbeiro' => 'sometimes|exists:barbeiros,barbeiro_id',
                'especialidade' => 'sometimes|exists:especialidades,especialidade_id'
            ]);

            $input['user'] = $request->user;

            $response = $this->listaAgendamentos->execute(new ListaAgendamentosInput(
                $input['user']->usuarioId,
                $input['user']->admin,
                $input['data'] ?? null,
                $input['barbeiro'] ?? null,
                $input['especialidade'] ?? null
            ));

            return response()->json([
                'status'=> 'success',
                'message'=> 'Agendamentos listados com sucesso',
                'agendamentos'=> $response->agendamentos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=> $e->getMessage() ?: 'Erro interno do servidor',
                ], $e->getCode() ?: 500);
        }
    }
}
