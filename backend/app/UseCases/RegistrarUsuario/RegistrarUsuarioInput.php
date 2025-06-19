<?php

namespace App\UseCases\RegistrarUsuario;

class RegistrarUsuarioInput
{
    public function __construct(
        public string $nome,
        public string $email,
        public string $senha,
        public bool $admin = false
    ) {}
}