<?php

namespace App\UseCases\CadastraBarbeiro;

interface CadastraBarbeiroInterface
{
    public function execute(CadastraBarbeiroInput $input): CadastraBarbeiroOutput;
}