<?php

namespace App\UseCases\RegistrarUsuario;

use App\UseCases\RegistrarUsuario\RegistrarUsuarioInput;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioOutput;

interface RegistrarUsuarioInterface
{
    public function execute(RegistrarUsuarioInput $input): RegistrarUsuarioOutput;
}