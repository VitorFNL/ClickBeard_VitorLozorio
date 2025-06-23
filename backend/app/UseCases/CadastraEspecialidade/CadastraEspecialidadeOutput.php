<?php

namespace App\UseCases\CadastraEspecialidade;

class CadastraEspecialidadeOutput
{
    public function __construct(
        public int $id,
        public string $descricao
    ) {}
}