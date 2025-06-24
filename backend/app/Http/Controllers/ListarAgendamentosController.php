<?php

namespace App\Http\Controllers;

use App\UseCases\ListarAgendamentos\ListarAgendamentosInput;
use App\UseCases\ListarAgendamentos\ListarAgendamentosInterface;
use App\Infrastructure\Persistence\Mappers\AgendamentoMapper;
use Illuminate\Http\Request;

class ListarAgendamentosController extends Controller
{
    
    public function __construct(
        private ListarAgendamentosInterface $listarAgendamentos
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

            $data = null;
            if (isset($input['data'])) {
                $data = new \DateTime($input['data']);
            }

            $response = $this->listarAgendamentos->execute(new ListarAgendamentosInput(
                $input['user']->usuarioId,
                $input['user']->admin,
                $data,
                $input['barbeiro'] ?? null,
                $input['especialidade'] ?? null
            ));

            // Converter entidades de domínio para arrays formatados
            $agendamentosArray = array_map([AgendamentoMapper::class, 'domainToArray'], $response->agendamentos);

            return response()->json([
                'status'=> 'success',
                'message'=> 'Agendamentos listados com sucesso',
                'agendamentos'=> $agendamentosArray
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=> $e->getMessage() ?: 'Erro interno do servidor',
                ], $e->getCode() ?: 500);
        }
    }
}
