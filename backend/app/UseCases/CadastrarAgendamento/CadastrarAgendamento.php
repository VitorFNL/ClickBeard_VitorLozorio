<?php

namespace App\UseCases\CadastrarAgendamento;

use App\Domain\Entities\Agendamento;
use App\Domain\Entities\Barbeiro;
use App\Domain\Enums\StatusAgendamentoEnum;
use App\Domain\Repositories\AgendamentoRepositoryInterface;
use App\Domain\Repositories\BarbeiroRepositoryInterface;

class CadastrarAgendamento implements CadastrarAgendamentoInterface
{

    public function __construct(
        private AgendamentoRepositoryInterface $agendamentoRepository,
        private BarbeiroRepositoryInterface $barbeiroRepository,
    ) {}

    public function execute(CadastrarAgendamentoInput $input): CadastrarAgendamentoOutput
    {
        if ($input->data < now()->format('Y-m-d')) {
            throw new \Exception('Data não pode ser anterior ao dia atual', 400);
        }
        if ($input->data === now()->format('Y-m-d') && $input->hora < now()->format('H:i')) {
            throw new \Exception('Data e hora não podem ser anteriores ao horário atual', 400);
        }

        if ($input->hora < '08:00' || $input->hora > '18:00') {
            throw new \Exception('Estabelecimento fechado neste horário. Agendamentos só podem ser feitos entre 08:00 e 18:00', 400);
        }

        $barbeirosDisponiveis = $this->barbeiroRepository->findDisponiveis($input->especialidadeId, $input->data, $input->hora);
        

        if (empty($barbeirosDisponiveis)) {
            throw new \Exception('Barbeiro não disponível na data e hora solicitada', 400);
        }        // pegar apenas o barbeiro específico
        $barbeirosFiltered = array_filter($barbeirosDisponiveis, function (Barbeiro $barbeiro) use ($input) {
            return $barbeiro->barbeiroId === $input->barbeiroId;
        });
        
        $barbeiro = array_values($barbeirosFiltered)[0] ?? null;

        if (!$barbeiro) {
            throw new \Exception('Barbeiro não disponível na data e hora solicitada', 400);
        }

        $especialidade = array_filter($barbeiro->especialidades, function ($especialidade) use ($input) {
            return $especialidade->especialidadeId === $input->especialidadeId;
        })[0];

        $hora_inicio = \DateTime::createFromFormat('H:i', $input->hora);
        if (!$hora_inicio) {
            throw new \Exception('Formato de hora inválido. Use HH:MM', 400);
        }
        $hora_fim = (clone $hora_inicio)->modify('+30 minutes');

        $agendamento = new Agendamento(
            $input->cliente,
            $barbeiro,
            $especialidade,
            new \DateTime($input->data),
            $hora_inicio,
            $hora_fim,
            StatusAgendamentoEnum::AGENDADO
        );

        $agendamento = $this->agendamentoRepository->salvar($agendamento);

        return new CadastrarAgendamentoOutput(
            $agendamento->agendamentoId,
            $agendamento->status->value
        );
    }
}