<?php

namespace App\UseCases\VincularEspecialidadesBarbeiro;

interface VincularEspecialidadesBarbeiroInterface
{
    public function execute(VincularEspecialidadesBarbeiroInput $input): VincularEspecialidadesBarbeiroOutput;
}