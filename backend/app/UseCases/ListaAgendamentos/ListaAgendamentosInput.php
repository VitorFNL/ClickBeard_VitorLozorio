<?php

namespace App\UseCases\ListaAgendamentos;

use Date;

class ListaAgendamentosInput
{
    public function __construct(
        public int $usuarioId,
        public bool $admin,
        public ?Date $data = null,
        public ?int $barbeiroId = null,
        public ?int $especialidadeId = null
    ) {}
}