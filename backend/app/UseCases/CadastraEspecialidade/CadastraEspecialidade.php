<?php

namespace App\UseCases\CadastraEspecialidade;

use App\Domain\Entities\Especialidade;
use App\Domain\Repositories\EspecialidadeRepositoryInterface;

class CadastraEspecialidade implements CadastraEspecialidadeInterface
{
    public function __construct(
        private EspecialidadeRepositoryInterface $especialidadeRepository
    ) {}

    public function execute(CadastraEspecialidadeInput $input): CadastraEspecialidadeOutput
    {
        $especialidade = new Especialidade(
            descricao: $input->descricao
        );

        $especialidade = $this->especialidadeRepository->salvar($especialidade);

        return new CadastraEspecialidadeOutput(
            id: $especialidade->especialidadeId,
            descricao: $especialidade->descricao
        );
    }
}