<?php

namespace App\Services; // Exemplo de namespace para um serviço de autenticação

use App\Domain\Entities\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $jwtSecret;
    private string $algorithm = 'HS256';

    public function __construct()
    {
        $secret = env('JWT_SECRET');

        if (empty($secret)) {
            throw new \RuntimeException('variavel de ambiente JWT_SECRET nao encontrada');
        }

        $this->jwtSecret = $secret;
    }

    public function generateToken(Usuario $usuario, array $customClaims = []): string
    {
        $time_geracao = time();
        $expiracao = $time_geracao + (60 * 60);

        $payload = [
            'iss' => env('APP_URL'),
            'sub' => $usuario->usuarioId,
            'iat' => $time_geracao,
            'exp' => $expiracao,
            'user_data' => [
                'id' => $usuario->usuarioId,
                'name' => $usuario->nome,
                'email' => $usuario->email,
                'admin' => $usuario->admin
            ]
        ];

        $payload = array_merge($payload, $customClaims);

        $token = JWT::encode($payload, $this->jwtSecret, $this->algorithm);

        return $token;
    }

    public function decodeToken(string $token): object
    {
        $decoded = JWT::decode($token, new Key($this->jwtSecret, $this->algorithm));

        return $decoded;
    }
}