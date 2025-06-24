<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\CadastrarAgendamento\CadastrarAgendamentoInput;
use App\UseCases\CadastrarAgendamento\CadastrarAgendamentoInterface;
use Illuminate\Http\Request;

class CadastrarAgendamentoController extends Controller
{
    public function __construct(
        private CadastrarAgendamentoInterface $cadastrarAgendamento
    ) {}
    public function __invoke(Request $request)
    {
        try {
            $input = $request->validate([
                'especialidade_id' => 'required|exists:especialidades,especialidade_id',
                'barbeiro_id' => 'required|exists:barbeiros,barbeiro_id',
                'data' => 'required|date_format:Y-m-d',
                'hora' => 'required|date_format:H:i',
            ]);

            $input['cliente'] = $request->user;

            $response = $this->cadastrarAgendamento->execute(new CadastrarAgendamentoInput(
                $input['cliente'],
                $input['especialidade_id'],
                $input['barbeiro_id'],
                $input['data'],
                $input['hora']
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Agendamento cadastrado com sucesso',
                'agendamento' => [
                    'id' => $response->agendamentoId,
                    'status' => $response->status,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
