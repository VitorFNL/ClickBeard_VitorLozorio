<?php

namespace App\UseCases\ListarBarbeiros;

class ListarBarbeirosInput
{
    public function __construct(
        public bool $isAdmin = false,
        public ?\DateTime $data = null,
        public ?\DateTime $hora = null,
        public ?int $especialidadeId = null,
    ) {}
}