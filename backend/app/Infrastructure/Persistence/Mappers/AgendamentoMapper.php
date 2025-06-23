<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Agendamento;
use App\Domain\Entities\Barbeiro;
use App\Domain\Entities\Especialidade;
use App\Domain\Entities\Usuario;
use App\Domain\Enums\StatusAgendamentoEnum;
use App\Models\EloquentAgendamento;

class AgendamentoMapper
{
    public static function toDomain(EloquentAgendamento $agendamento, Usuario $usuario, Barbeiro $barbeiro, Especialidade $especialidade): Agendamento
    {
        return new Agendamento(
            $usuario,
            $barbeiro,
            $especialidade,
            new \DateTime($agendamento->data_agendamento),
            new \DateTime($agendamento->hora_inicio),
            new \DateTime($agendamento->hora_fim),
            StatusAgendamentoEnum::from($agendamento->status_agendamento),
            $agendamento->agendamento_id,
            $agendamento->data_criacao ? new \DateTime($agendamento->data_criacao) : null,
            $agendamento->data_atualizacao ? new \DateTime($agendamento->data_atualizacao) : null
        );
    }

    public static function domainToEloquent(Agendamento $domainAgendamento, ?EloquentAgendamento $eloquentAgendamento = null): EloquentAgendamento
    {
        $agendamento = $eloquentAgendamento ?? new EloquentAgendamento();

        if ($domainAgendamento->agendamentoId !== null) {
            $agendamento->agendamento_id = $domainAgendamento->agendamentoId;
        }

        $agendamento->usuario_id = $domainAgendamento->usuario->usuarioId;
        $agendamento->barbeiro_id = $domainAgendamento->barbeiro->barbeiroId;
        $agendamento->especialidade_id = $domainAgendamento->especialidade->especialidadeId;
        $agendamento->data_agendamento = $domainAgendamento->dataAgendamento->format('Y-m-d');
        $agendamento->hora_inicio = $domainAgendamento->horaInicio->format('H:i:s');
        $agendamento->hora_fim = $domainAgendamento->horaFim->format('H:i:s');
        $agendamento->status_agendamento = $domainAgendamento->status->value;

        if ($domainAgendamento->dataCriacao) {
            $agendamento->data_criacao = $domainAgendamento->dataCriacao->format('Y-m-d H:i:s');
        }

        if ($domainAgendamento->dataAtualizacao) {
            $agendamento->data_atualizacao = $domainAgendamento->dataAtualizacao->format('Y-m-d H:i:s');
        }

        return $agendamento;
    }
}