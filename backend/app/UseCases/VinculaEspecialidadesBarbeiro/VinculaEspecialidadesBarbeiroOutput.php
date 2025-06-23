<?php

namespace App\UseCases\VinculaEspecialidadesBarbeiro;

use App\Domain\Entities\Especialidade;

class VinculaEspecialidadesBarbeiroOutput
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