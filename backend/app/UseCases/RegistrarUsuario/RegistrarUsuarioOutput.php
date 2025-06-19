<?php

namespace App\UseCases\RegistrarUsuario;

class RegistrarUsuarioOutput
{
    public function __construct(
        public string $nome
    ) {}
}