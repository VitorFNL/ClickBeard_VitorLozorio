<?php

namespace App\UseCases\CancelarAgendamento;

use App\Domain\Enums\StatusAgendamentoEnum;
use App\Domain\Repositories\AgendamentoRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\AgendamentoMapper;

class CancelarAgendamento implements CancelarAgendamentoInterface
{
    public function __construct(
        private AgendamentoRepositoryInterface $agendamentoRepository
    ) {}

    public function execute(CancelarAgendamentoInput $input): CancelarAgendamentoOutput
    {
        $agendamento = $this->agendamentoRepository->findById($input->agendamentoId);

        // Verifica se o agendamento existe
        if (!$agendamento) {
            throw new \Exception('Agendamento não encontrado', 404);
        }

        if ($agendamento->status->value != 'AGENDADO') {
            throw new \Exception('Agendamento não pode ser cancelado.', 400);
        }

        if ($agendamento->usuario->usuarioId != $input->usuarioId) {
            throw new \Exception('Usuário não tem permissão para cancelar este agendamento.', 403);
        }

        if ($agendamento->dataAgendamento == now()->format('Y-m-d') && $agendamento->horaInicio < now()->addHours(2)->format('H:i')) {
            throw new \Exception('Agendamento não pode ser cancelado com menos de 2 horas de antecedência.', 400);
        }

        $agendamento->status = StatusAgendamentoEnum::CANCELADO;

        $this->agendamentoRepository->salvar($agendamento);

        // Retorna a saída com o ID do agendamento e o status atualizado
        return new CancelarAgendamentoOutput($agendamento->agendamentoId, $agendamento->status->value);
    }
}