<?php

namespace App\UseCases\ListarAgendamentos;

class ListarAgendamentosOutput
{
    public function __construct(
        public array $agendamentos
    ) {}
}