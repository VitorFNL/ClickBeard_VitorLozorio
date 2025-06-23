<?php

namespace App\UseCases\VincularEspecialidadesBarbeiro;

use App\Domain\Entities\Especialidade;

class VincularEspecialidadesBarbeiroOutput
{
    /**
     *
     * @param int $barbeiroId
     * @param Especialidade[] $especialidades
     */
    public function __construct(
        public int $barbeiroId,
        public array $especialidades,
    ) {}
}