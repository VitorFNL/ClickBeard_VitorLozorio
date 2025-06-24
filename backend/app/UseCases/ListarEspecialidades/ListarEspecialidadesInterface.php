<?php

namespace App\UseCases\ListarEspecialidades;

interface ListarEspecialidadesInterface
{
    public function execute(ListarEspecialidadesInput $input): ListarEspecialidadesOutput;
}
