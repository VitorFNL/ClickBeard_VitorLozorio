<?php

namespace App\UseCases\CadastrarBarbeiro;

class CadastrarBarbeiroOutput
{
    public function __construct(
        public int $id,
        public string $nome
    ) {}
}