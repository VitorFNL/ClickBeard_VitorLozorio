<?php

namespace App\UseCases\RegistrarUsuario;

use App\Domain\Entities\Usuario;
use App\Domain\Repositories\UsuarioRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegistrarUsuario implements RegistrarUsuarioInterface
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function execute(RegistrarUsuarioInput $input): RegistrarUsuarioOutput
    {
        $usuario = new Usuario(
            usuarioId: null,
            nome: $input->nome,
            email: $input->email,
            senhaHash: Hash::make($input->senha),
            admin: $input->admin
        );

        $usuario_criado = $this->usuarioRepository->salvar($usuario);

        return new RegistrarUsuarioOutput($usuario_criado->nome);
    }
}