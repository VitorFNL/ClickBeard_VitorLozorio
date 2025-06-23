<?php

namespace App\UseCases\VincularEspecialidadesBarbeiro;

class VincularEspecialidadesBarbeiroInput
{
    public function __construct(
        public int $barbeiroId,
        public array $especialidadesIds,
    ) {}
}