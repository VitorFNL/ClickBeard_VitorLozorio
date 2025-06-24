<?php

namespace App\UseCases\CancelarAgendamento;

interface CancelarAgendamentoInterface
{
    public function execute(CancelarAgendamentoInput $input): CancelarAgendamentoOutput;
}