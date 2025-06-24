<?php

namespace App\UseCases\ListarEspecialidades;

use App\Domain\Entities\Especialidade;

class ListarEspecialidadesOutput
{
    /**
     *
     * @param Especialidade[] $especialidades
     */
    public function __construct(
        public array $especialidades
    ) {}
}
