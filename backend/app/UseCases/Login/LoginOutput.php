<?php

namespace App\UseCases\Login;

class LoginOutput
{
    public function __construct(
        public string $token
    ) {}
}