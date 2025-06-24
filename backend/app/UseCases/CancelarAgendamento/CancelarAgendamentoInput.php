<?php

namespace App\UseCases\CancelarAgendamento;

class CancelarAgendamentoInput
{
    public function __construct(
        public int $usuarioId,
        public int $agendamentoId
    ) {}
}