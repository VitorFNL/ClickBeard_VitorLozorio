<?php

namespace App\Domain\Entities;

class Usuario
{
    public function __construct(
        public ?int $usuarioId = null,
        public string $nome,
        public string $email,
        public string $senha,
        public bool $admin,
        public ?\DateTime $dataCriacao = null,
        public ?\DateTime $dataAtualizacao = null
    ) {}

}