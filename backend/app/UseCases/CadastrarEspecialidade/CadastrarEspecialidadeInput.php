<?php

namespace App\UseCases\CadastrarEspecialidade;

class CadastrarEspecialidadeInput
{
    public function __construct(
        public string $descricao
    ) {}
}