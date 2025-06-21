<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Barbeiro;
use App\Models\EloquentBarbeiro;
use Date;
use DateTime;

class BarbeiroMapper
{
    public static function EloquentToDomain(EloquentBarbeiro $barbeiro): Barbeiro
    {
        return new Barbeiro(
            $barbeiro->nome,
            new DateTime($barbeiro->data_nascimento),
            new DateTime($barbeiro->data_contratacao),
            $barbeiro->ativo,
            $barbeiro->barbeiro_id,
            new DateTime($barbeiro->data_criacao),
            new DateTime($barbeiro->data_atualizacao)
        );
    }
}