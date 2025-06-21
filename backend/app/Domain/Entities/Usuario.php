<?php

namespace App\Domain\Entities;

class Usuario
{
    public function __construct(
        public string $nome,
        public string $email,
        public string $senhaHash,
        public bool $admin,
        public ?int $usuarioId = null,
        public ?\DateTime $dataCriacao = null,
        public ?\DateTime $dataAtualizacao = null
    ) {}

}