<?php

namespace App\UseCases\Login;

use App\Domain\Repositories\UsuarioRepositoryInterface;
use App\Services\JwtService;

class Login implements LoginInterface
{
    public function __construct(
        private JwtService $jwtService,
        private UsuarioRepositoryInterface $usuarioRepository
    ) {}

    public function execute(LoginInput $input): LoginOutput
    {
        $usuario = $this->usuarioRepository->autenticar($input->email, $input->senha);

        if (!$usuario) {
            throw new \Exception('Usuário ou senha inválidos');
        }

        $token = $this->jwtService->generateToken($usuario);

        return new LoginOutput($token, $usuario);
    }
}