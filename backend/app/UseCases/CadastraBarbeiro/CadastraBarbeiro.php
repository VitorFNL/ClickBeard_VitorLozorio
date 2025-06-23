<?php

namespace App\UseCases\CadastraBarbeiro;

use App\Domain\Entities\Barbeiro;
use App\Domain\Repositories\BarbeiroRepositoryInterface;

class CadastraBarbeiro implements CadastraBarbeiroInterface
{
    public function __construct(
        private BarbeiroRepositoryInterface $barbeiroRepository
    ) {}

    public function execute(CadastraBarbeiroInput $input): CadastraBarbeiroOutput
    {
        $barbeiro = new Barbeiro(
            nome: $input->nome,
            dataNascimento: new \DateTime($input->dataNascimento),
            dataContratacao: new \DateTime($input->dataContratacao),
            ativo: true
        );

        $barbeiro = $this->barbeiroRepository->salvar($barbeiro);

        return new CadastraBarbeiroOutput(
            id: $barbeiro->barbeiroId,
            nome: $barbeiro->nome
        );
    }
}