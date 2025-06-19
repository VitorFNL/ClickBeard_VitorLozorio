<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Usuario;
use App\Domain\Repositories\UsuarioRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\UsuarioEloquentDomainMapper;
use App\Models\EloquentUsuario;
use Illuminate\Support\Facades\Auth;

class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    public function findById(int $usuarioId): ?Usuario
    {
        $eloquentUsuario = EloquentUsuario::find($usuarioId);

        if (!$eloquentUsuario) {
            return null;
        }

        $usuario = UsuarioEloquentDomainMapper::toDomain($eloquentUsuario);

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

        $usuario = UsuarioEloquentDomainMapper::toDomain($eloquentUsuario);

        return $usuario;
    }

    public function autenticar(string $email, string $senha): ?Usuario
    {
        $autenticado = Auth::attempt(["email"=> $email, "password"=> $senha]);

        if (!$autenticado) {
            return null;
        }

        $eloquentUsuario = Auth::user();

        $usuario = UsuarioEloquentDomainMapper::toDomain($eloquentUsuario);

        return $usuario;
    }

    public function salvar(Usuario $usuario): Usuario
    {
        $eloquentUser = $usuario->usuarioId ? EloquentUsuario::find($usuario->usuarioId) : new EloquentUsuario();


        $eloquentUser = UsuarioEloquentDomainMapper::toEloquent($usuario, $eloquentUser);

        $eloquentUser->save();

        return UsuarioEloquentDomainMapper::toDomain($eloquentUser);
    }
}