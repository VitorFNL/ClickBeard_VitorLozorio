<?php

namespace App\UseCases\CadastraBarbeiro;

class CadastraBarbeiroOutput
{
    public function __construct(
        public int $id,
        public string $nome
    ) {}
}