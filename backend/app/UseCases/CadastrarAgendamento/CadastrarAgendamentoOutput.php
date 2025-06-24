<?php

namespace App\UseCases\CadastrarAgendamento;

class CadastrarAgendamentoOutput
{
    public function __construct(
        public int $agendamentoId,
        public string $status
    ) {}
}