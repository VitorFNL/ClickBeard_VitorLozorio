<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Especialidade;
use App\Models\EloquentEspecialidade;

class EspecialidadeMapper
{
    public static function EloquentToDomain(EloquentEspecialidade $especialidade): Especialidade
    {
        return new Especialidade(
            $especialidade->descricao,
            $especialidade->especialidade_id,
            $especialidade->data_criacao,
            $especialidade->data_atualizacao
        );
    }

    public static function domainToArray(Especialidade $especialidade): array
    {
        return [
            'id' => $especialidade->especialidadeId,
            'descricao' => $especialidade->descricao,
            'data_criacao' => $especialidade->dataCriacao,
            'data_atualizacao' => $especialidade->dataAtualizacao,
        ];
    }
}