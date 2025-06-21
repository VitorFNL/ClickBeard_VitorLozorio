<?php

namespace App\UseCases\Login;

interface LoginInterface
{
    public function execute(LoginInput $input): LoginOutput;
}