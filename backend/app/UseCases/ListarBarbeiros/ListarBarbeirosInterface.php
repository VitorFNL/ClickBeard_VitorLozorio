<?php

namespace App\UseCases\ListarBarbeiros;

interface ListarBarbeirosInterface
{
    public function execute(ListarBarbeirosInput $input): ListarBarbeirosOutput;
}