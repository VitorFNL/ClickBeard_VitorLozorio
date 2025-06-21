<?php

namespace App\Domain\Enums;

enum StatusAgendamentoEnum: string
{
    case AGENDADO = 'AGENDADO';
    case CANCELADO = 'CANCELADO';
    case CONCLUIDO = 'CONCLUIDO';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
