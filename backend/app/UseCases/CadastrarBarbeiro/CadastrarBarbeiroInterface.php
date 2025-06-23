<?php

namespace App\UseCases\CadastrarBarbeiro;

interface CadastrarBarbeiroInterface
{
    public function execute(CadastrarBarbeiroInput $input): CadastrarBarbeiroOutput;
}