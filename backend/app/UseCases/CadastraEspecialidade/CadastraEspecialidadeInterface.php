<?php

namespace App\UseCases\CadastraEspecialidade;

interface CadastraEspecialidadeInterface
{
    public function execute(CadastraEspecialidadeInput $input): CadastraEspecialidadeOutput;
}