<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Usuario;
use App\Models\EloquentUsuario;
use DateTime;

class UsuarioMapper
{
    public static function EloquentToDomain(EloquentUsuario $usuario): Usuario
    {
        return new Usuario(
            $usuario->nome,
            $usuario->email,
            $usuario->senha,
            $usuario->admin,
            $usuario->id,
            new DateTime($usuario->data_criacao),
            new DateTime($usuario->data_atualizacao)
        );
    }

    public static function DomainToEloquent(Usuario $domainUser, ?EloquentUsuario $eloquentUser = null): EloquentUsuario
    {
        $eloquentUser = $eloquentUser ?? new EloquentUsuario();


        if ($domainUser->usuarioId !== null) {
            $eloquentUser->usuario_id = $domainUser->usuarioId;
        }

        $eloquentUser->nome = $domainUser->nome;
        $eloquentUser->email = $domainUser->email;
        $eloquentUser->senha = $domainUser->senhaHash;
        $eloquentUser->admin = $domainUser->admin;

        if ($domainUser->dataCriacao) {
            $eloquentUser->data_criacao = $domainUser->dataCriacao->format('Y-m-d H:i:s');
        }
        if ($domainUser->dataAtualizacao) {
            $eloquentUser->data_atualizacao = $domainUser->dataAtualizacao->format('Y-m-d H:i:s');
        }

        return $eloquentUser;
    }

    public static function fromJwtPayload(\stdClass $payloadUserData): Usuario
    {
        return new Usuario(
            usuarioId: $payloadUserData->id,
            nome: $payloadUserData->name,
            email: $payloadUserData->email,
            senhaHash: '',
            admin: (bool) $payloadUserData->admin,
            dataCriacao: null,
            dataAtualizacao: null
        );
    }
}