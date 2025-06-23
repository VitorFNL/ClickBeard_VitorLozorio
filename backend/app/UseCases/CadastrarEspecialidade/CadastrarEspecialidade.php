<?php

namespace App\UseCases\CadastrarEspecialidade;

use App\Domain\Entities\Especialidade;
use App\Domain\Repositories\EspecialidadeRepositoryInterface;

class CadastrarEspecialidade implements CadastrarEspecialidadeInterface
{
    public function __construct(
        private EspecialidadeRepositoryInterface $especialidadeRepository
    ) {}

    public function execute(CadastrarEspecialidadeInput $input): CadastrarEspecialidadeOutput
    {
        $especialidade = new Especialidade(
            descricao: $input->descricao
        );

        $especialidade = $this->especialidadeRepository->salvar($especialidade);

        return new CadastrarEspecialidadeOutput(
            id: $especialidade->especialidadeId,
            descricao: $especialidade->descricao
        );
    }
}