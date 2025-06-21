<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Agendamento;
use App\Domain\Entities\Barbeiro;
use App\Domain\Entities\Especialidade;
use App\Domain\Entities\Usuario;
use App\Models\EloquentAgendamento;

class AgendamentoMapper
{
    public static function toDomain(EloquentAgendamento $agendamento, Usuario $usuario, Barbeiro $barbeiro, Especialidade $especialidade): Agendamento
    {
        return new Agendamento(
            $usuario,
            $barbeiro,
            $especialidade,
            $agendamento->data_agendamento,
            $agendamento->hora_inicio,
            $agendamento->hora_fim,
            $agendamento->status,
            $agendamento->agendamento_id,
            $agendamento->data_criacao,
            $agendamento->data_atualizacao
        );
    }
}