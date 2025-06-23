<?php

namespace App\UseCases\CadastrarEspecialidade;

interface CadastrarEspecialidadeInterface
{
    public function execute(CadastrarEspecialidadeInput $input): CadastrarEspecialidadeOutput;
}