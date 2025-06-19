<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Usuario;

interface UsuarioRepositoryInterface
{
    public function findById(int $id): ?Usuario;
    public function findByEmail(string $email): ?Usuario;
    public function autenticar(string $email, string $senha): ?Usuario;
    public function salvar(Usuario $usuario): Usuario;
}