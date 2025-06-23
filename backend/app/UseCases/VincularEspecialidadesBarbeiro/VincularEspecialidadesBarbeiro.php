<?php

namespace App\UseCases\VincularEspecialidadesBarbeiro;

use App\Domain\Repositories\BarbeiroRepositoryInterface;

class VincularEspecialidadesBarbeiro implements VincularEspecialidadesBarbeiroInterface
{
    public function __construct(
        private BarbeiroRepositoryInterface $barbeiroRepository,
    ) {}

    public function execute(VincularEspecialidadesBarbeiroInput $input): VincularEspecialidadesBarbeiroOutput
    {
        $barbeiro_atualizado = $this->barbeiroRepository->vincularEspecialidades($input->barbeiroId, $input->especialidadesIds);

        return new VincularEspecialidadesBarbeiroOutput($barbeiro_atualizado->barbeiroId, $barbeiro_atualizado->especialidades);
    }
}