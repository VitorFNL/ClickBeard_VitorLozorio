<?php

namespace App\UseCases\CadastraBarbeiro;

class CadastraBarbeiroInput
{
    public function __construct(
        public string $nome,
        public string $dataNascimento,
        public string $dataContratacao,
    ) {}
}