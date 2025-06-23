<?php

namespace App\UseCases\ListarAgendamentos;

use DateTime;

class ListarAgendamentosInput
{
    public function __construct(
        public int $usuarioId,
        public bool $admin,
        public ?DateTime $data = null,
        public ?int $barbeiroId = null,
        public ?int $especialidadeId = null
    ) {}
}