<?php

namespace App\UseCases\ListaAgendamentos;

class ListaAgendamentos implements ListaAgendamentosInterface
{
    public function __construct(
        private AgendamentoRepositoryInterface $agendamentoRepository
    ) {}

    public function execute(ListaAgendamentosInput $input): ListaAgendamentosOutput
    {

        return new ListaAgendamentosOutput([]);
    }
}