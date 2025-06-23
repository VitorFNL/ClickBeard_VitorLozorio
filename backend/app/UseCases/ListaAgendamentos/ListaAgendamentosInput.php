<?php

namespace App\UseCases\ListaAgendamentos;

use DateTime;

class ListaAgendamentosInput
{
    public function __construct(
        public int $usuarioId,
        public bool $admin,
        public ?DateTime $data = null,
        public ?int $barbeiroId = null,
        public ?int $especialidadeId = null
    ) {}
}