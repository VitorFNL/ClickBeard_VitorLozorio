<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\CancelarAgendamento\CancelarAgendamentoInput;
use App\UseCases\CancelarAgendamento\CancelarAgendamentoInterface;
use Illuminate\Http\Request;

class CancelarAgendamentoController extends Controller
{

    public function __construct(
        private CancelarAgendamentoInterface $cancelarAgendamento
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'agendamento_id' => 'required|exists:agendamentos,agendamento_id',
            ]);

            $input['usuario'] = $request->user;

            $response = $this->cancelarAgendamento->execute(new CancelarAgendamentoInput(
                $input['usuario']->usuarioId,
                $input['agendamento_id']
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Agendamento cancelado com sucesso',
                'agendamento' => [
                    'id' => $response->agendamentoId,
                    'status' => $response->status,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
