<?php

namespace App\Domain\Entities;

class Especialidade
{
    public function __construct(
        public string $descricao,
        public ?int $especialidadeId = null,
        public ?\DateTime $dataCriacao = null,
        public ?\DateTime $dataAtualizacao = null
    ) {}
}