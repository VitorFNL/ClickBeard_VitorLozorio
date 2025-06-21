<?php

namespace App\UseCases\ListaAgendamentos;

class ListaAgendamentosOutput
{
    public function __construct(
        public array $agendamentos
    ) {}
}