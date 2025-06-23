<?php

namespace App\UseCases\ListarAgendamentos;

interface ListarAgendamentosInterface
{
    public function execute(ListarAgendamentosInput $input): ListarAgendamentosOutput;
}