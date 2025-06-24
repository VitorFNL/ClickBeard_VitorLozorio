<?php

namespace App\UseCases\CadastrarAgendamento;

use App\Domain\Entities\Usuario;

class CadastrarAgendamentoInput
{
    public function __construct(
        public Usuario $cliente,
        public int $especialidadeId,
        public int $barbeiroId,
        public string $data,
        public string $hora
    ) {}
}