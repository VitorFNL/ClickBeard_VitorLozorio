<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Barbeiro;
use App\Domain\Entities\Especialidade;
use App\Models\EloquentBarbeiro;
use DateTime;

class BarbeiroMapper
{
    /**
     * Converte um objeto EloquentBarbeiro para um objeto Barbeiro do domínio.
     *
     * @param EloquentBarbeiro $barbeiro
     * @param Especialidade[]|null $especialidades
     * @return Barbeiro
     */
    public static function EloquentToDomain(EloquentBarbeiro $barbeiro, ?array $especialidades = null): Barbeiro
    {
        return new Barbeiro(
            $barbeiro->nome,
            new DateTime($barbeiro->data_nascimento),
            new DateTime($barbeiro->data_contratacao),
            $barbeiro->ativo,
            $barbeiro->barbeiro_id,
            new DateTime($barbeiro->data_criacao),
            new DateTime($barbeiro->data_atualizacao),
            $especialidades
        );
    }

    public static function DomainToEloquent(Barbeiro $domainBarbeiro, ?EloquentBarbeiro $eloquentBarbeiro = null): EloquentBarbeiro
    {
        $barbeiro = $eloquentBarbeiro ?? new EloquentBarbeiro();

        if ($domainBarbeiro->barbeiroId !== null) {
            $barbeiro->barbeiro_id = $domainBarbeiro->barbeiroId;
        }

        $barbeiro->nome = $domainBarbeiro->nome;
        $barbeiro->data_nascimento = $domainBarbeiro->dataNascimento->format('Y-m-d');
        $barbeiro->data_contratacao = $domainBarbeiro->dataContratacao->format('Y-m-d');
        $barbeiro->ativo = $domainBarbeiro->ativo;

        if ($domainBarbeiro->dataCriacao) {
            $barbeiro->data_criacao = $domainBarbeiro->dataCriacao->format('Y-m-d H:i:s');
        }

        if ($domainBarbeiro->dataAtualizacao) {
            $barbeiro->data_atualizacao = $domainBarbeiro->dataAtualizacao->format('Y-m-d H:i:s');
        }

        return $barbeiro;
    }
}