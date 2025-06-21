<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Especialidade;
use App\Models\EloquentEspecialidade;

class EspecialidadeMapper
{
    public static function EloquentToDomain(EloquentEspecialidade $especialidade): Especialidade
    {
        return new Especialidade(
            $especialidade->nome,
            $especialidade->especialidade_id,
            $especialidade->data_criacao,
            $especialidade->data_atualizacao
        );
    }
}