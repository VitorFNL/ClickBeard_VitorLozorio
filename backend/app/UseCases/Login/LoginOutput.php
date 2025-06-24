<?php

namespace App\UseCases\Login;

use App\Domain\Entities\Usuario;

class LoginOutput
{
    public function __construct(
        public string $token,
        public Usuario $usuario
    ) {}
}