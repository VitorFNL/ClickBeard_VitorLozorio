<?php

namespace App\UseCases\VinculaEspecialidadesBarbeiro;

use App\Domain\Repositories\BarbeiroRepositoryInterface;

class VinculaEspecialidadesBarbeiro implements VinculaEspecialidadesBarbeiroInterface
{
    public function __construct(
        private BarbeiroRepositoryInterface $barbeiroRepository,
    ) {}

    public function execute(VinculaEspecialidadesBarbeiroInput $input): VinculaEspecialidadesBarbeiroOutput
    {
        $barbeiro_atualizado = $this->barbeiroRepository->vincularEspecialidades($input->barbeiroId, $input->especialidadesIds);

        return new VinculaEspecialidadesBarbeiroOutput($barbeiro_atualizado->barbeiroId, $barbeiro_atualizado->especialidades);
    }
}