<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Usuario;
use App\Models\EloquentUsuario;

class UsuarioEloquentDomainMapper
{
    public static function toDomain(EloquentUsuario $usuario): Usuario
    {
        return new Usuario(
            $usuario->id,
            $usuario->nome,
            $usuario->email,
            $usuario->senha,
            $usuario->admin,
            $usuario->data_criacao,
            $usuario->data_atualizacao
        );
    }

    public static function toEloquent(Usuario $domainUser, ?EloquentUsuario $eloquentUser = null): EloquentUsuario
    {
        $eloquentUser = $eloquentUser ?? new EloquentUsuario();


        if ($domainUser->usuarioId !== null) {
            $eloquentUser->usuario_id = $domainUser->usuarioId;
        }

        $eloquentUser->nome = $domainUser->nome;
        $eloquentUser->email = $domainUser->email;
        $eloquentUser->senha = $domainUser->senha;
        $eloquentUser->admin = $domainUser->admin;

        if ($domainUser->dataCriacao) {
            $eloquentUser->data_criacao = $domainUser->dataCriacao->format('Y-m-d H:i:s');
        }
        if ($domainUser->dataAtualizacao) {
            $eloquentUser->data_atualizacao = $domainUser->dataAtualizacao->format('Y-m-d H:i:s');
        }

        return $eloquentUser;
    }
}