<?php

namespace App\UseCases\CadastrarAgendamento;

interface CadastrarAgendamentoInterface
{
    public function execute(CadastrarAgendamentoInput $input): CadastrarAgendamentoOutput;
}