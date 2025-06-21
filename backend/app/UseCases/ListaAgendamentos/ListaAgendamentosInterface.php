<?php

namespace App\UseCases\ListaAgendamentos;

interface ListaAgendamentosInterface
{
    public function execute(ListaAgendamentosInput $input): ListaAgendamentosOutput;
}