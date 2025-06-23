<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Barbeiro;

interface BarbeiroRepositoryInterface
{
    public function findById(int $barbeiroId): ?Barbeiro;
    /**
     * @return Barbeiro[]
     */
    public function findByNome(string $nome): array;
    /**
     * @return Barbeiro[]
     */
    public function findAll(): array;
    public function salvar(Barbeiro $barbeiro): Barbeiro;
    public function vincularEspecialidades(int $barbeiroId, array $especialidadesIds): Barbeiro;
    /**
     * data deve estar no formato 'Y-m-d', 
     * hora deve estar no formato 'H:i'
     * @return Barbeiro[]
     */
    public function findDisponiveis(int $especialidadeId, string $data, string $hora): array;
}