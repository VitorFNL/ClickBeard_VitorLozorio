<?php

namespace App\UseCases\VinculaEspecialidadesBarbeiro;

class VinculaEspecialidadesBarbeiroInput
{
    public function __construct(
        public int $barbeiroId,
        public array $especialidadesIds,
    ) {}
}