<?php

namespace App\UseCases\CadastrarEspecialidade;

class CadastrarEspecialidadeOutput
{
    public function __construct(
        public int $id,
        public string $descricao
    ) {}
}