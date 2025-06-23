<?php

namespace App\UseCases\VinculaEspecialidadesBarbeiro;

interface VinculaEspecialidadesBarbeiroInterface
{
    public function execute(VinculaEspecialidadesBarbeiroInput $input): VinculaEspecialidadesBarbeiroOutput;
}