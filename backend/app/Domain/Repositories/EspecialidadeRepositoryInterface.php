<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Especialidade;

interface EspecialidadeRepositoryInterface
{
    public function findById(int $especialidadeId): ?Especialidade;
    public function findByDescricao(string $descricao): ?Especialidade;
    /**
     * @return Especialidade[]
     */
    public function findAll(): array;
    public function salvar(Especialidade $especialidade): Especialidade;
}