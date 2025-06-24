<?php

namespace App\UseCases\CancelarAgendamento;

class CancelarAgendamentoOutput
{
    public function __construct(
        public int $agendamentoId,
        public string $status
    ) {}
}