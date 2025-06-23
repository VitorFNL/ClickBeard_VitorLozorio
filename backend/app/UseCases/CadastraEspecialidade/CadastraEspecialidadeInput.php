<?php

namespace App\UseCases\CadastraEspecialidade;

class CadastraEspecialidadeInput
{
    public function __construct(
        public string $descricao
    ) {}
}