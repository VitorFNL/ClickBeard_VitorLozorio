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
}