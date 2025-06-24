<?php

namespace App\UseCases\ListarEspecialidades;

use App\Domain\Repositories\EspecialidadeRepositoryInterface;

class ListarEspecialidades implements ListarEspecialidadesInterface
{
    public function __construct(
        private readonly EspecialidadeRepositoryInterface $especialidadeRepository
    ) {}

    public function execute(ListarEspecialidadesInput $input): ListarEspecialidadesOutput
    {
        // Busca todas as especialidades disponíveis
        $especialidades = $this->especialidadeRepository->findAll();

        return new ListarEspecialidadesOutput($especialidades);
    }
}
