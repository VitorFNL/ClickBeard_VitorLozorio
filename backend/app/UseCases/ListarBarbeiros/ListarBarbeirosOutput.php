<?php

namespace App\UseCases\ListarBarbeiros;

use App\Domain\Entities\Barbeiro;

class ListarBarbeirosOutput
{
    /**
     *
     * @param Barbeiro[] $barbeiros
     */
    public function __construct(
        public array $barbeiros
    ) {}
}