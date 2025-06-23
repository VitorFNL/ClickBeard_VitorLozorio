<?php

namespace App\UseCases\CadastrarBarbeiro;

class CadastrarBarbeiroInput
{
    public function __construct(
        public string $nome,
        public string $dataNascimento,
        public string $dataContratacao,
    ) {}
}