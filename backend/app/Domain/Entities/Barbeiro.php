<?php

namespace App\Domain\Entities;

class Barbeiro
{
    public function __construct(
        public string $nome,
        public \DateTime $dataNascimento,
        public \DateTime $dataContratacao,
        public bool $ativo,
        public ?int $barbeiroId = null,
        public ?\DateTime $dataCriacao = null,
        public ?\DateTime $dataAtualizacao = null,
        /** @var Especialidade[] */
        public array $especialidades = []
    ) {}
}