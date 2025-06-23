<?php

namespace App\UseCases\CadastrarBarbeiro;

use App\Domain\Entities\Barbeiro;
use App\Domain\Repositories\BarbeiroRepositoryInterface;

class CadastrarBarbeiro implements CadastrarBarbeiroInterface
{
    public function __construct(
        private BarbeiroRepositoryInterface $barbeiroRepository
    ) {}

    public function execute(CadastrarBarbeiroInput $input): CadastrarBarbeiroOutput
    {
        $barbeiro = new Barbeiro(
            nome: $input->nome,
            dataNascimento: new \DateTime($input->dataNascimento),
            dataContratacao: new \DateTime($input->dataContratacao),
            ativo: true
        );

        $barbeiro = $this->barbeiroRepository->salvar($barbeiro);

        return new CadastrarBarbeiroOutput(
            id: $barbeiro->barbeiroId,
            nome: $barbeiro->nome
        );
    }
}
