<?php

namespace App\UseCases\Login;

class LoginInput
{
    public function __construct(
        public string $email,
        public string $senha
    ) {}
}