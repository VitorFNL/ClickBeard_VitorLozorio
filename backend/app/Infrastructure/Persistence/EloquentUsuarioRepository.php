<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Usuario;
use App\Domain\Repositories\UsuarioRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\UsuarioMapper;
use App\Models\EloquentUsuario;
use Hash;
use Illuminate\Support\Facades\Auth;

class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    public function findById(int $usuarioId): ?Usuario
    {
        $eloquentUsuario = EloquentUsuario::find($usuarioId);

        if (!$eloquentUsuario) {
            return null;
        }

        $usuario = UsuarioMapper::EloquentToDomain($eloquentUsuario);

        return $usuario;
    }

    public function findByEmail(string $email): ?Usuario
    {
        $eloquentUsuario = EloquentUsuario::query()
                                        ->where("email", $email)
                                        ->first();

        if (!$eloquentUsuario) {
            return null;
        }

        $usuario = UsuarioMapper::EloquentToDomain($eloquentUsuario);

        return $usuario;
    }

    public function autenticar(string $email, string $senha): ?Usuario
    {
        $eloquentUsuario = EloquentUsuario::query()
                                        ->where("email", $email)
                                        ->first();

        if (!$eloquentUsuario) {
            return null;
        }

        if (!Hash::check($senha, $eloquentUsuario->senha)) {
            return null;
        }

        $usuario = UsuarioMapper::EloquentToDomain($eloquentUsuario);

        return $usuario;
    }

    public function salvar(Usuario $usuario): Usuario
    {
        $eloquentUser = $usuario->usuarioId ? EloquentUsuario::find($usuario->usuarioId) : new EloquentUsuario();


        $eloquentUser = UsuarioMapper::DomainToEloquent($usuario, $eloquentUser);

        $eloquentUser->save();

        return UsuarioMapper::EloquentToDomain($eloquentUser);
    }
}