<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Especialidade;
use App\Domain\Repositories\EspecialidadeRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\EspecialidadeMapper;
use App\Models\EloquentEspecialidade;

class EloquentEspecialidadeRepository implements EspecialidadeRepositoryInterface
{
    public function findById(int $id): ?Especialidade
    {
        $especialidade = EloquentEspecialidade::find($id);

        if (!$especialidade) {
            return null;
        }

        return EspecialidadeMapper::EloquentToDomain($especialidade);
    }

    public function findByDescricao(string $descricao): ?Especialidade
    {
        $especialidade = EloquentEspecialidade::where('descricao', $descricao)->first();

        if (!$especialidade) {
            return null;
        }

        return EspecialidadeMapper::EloquentToDomain($especialidade);
    }

    /**
     * @return Especialidade[]
     */
    public function findAll(): array
    {
        $especialidades = EloquentEspecialidade::all();

        if ($especialidades->isEmpty()) {
            return [];
        }

        $especialidades = $especialidades->map(function ($especialidade) {
            return EspecialidadeMapper::EloquentToDomain($especialidade);
        });

        return $especialidades->toArray();
    }

    public function salvar(Especialidade $especialidade): Especialidade
    {
        $eloquentEspecialidade = $especialidade->especialidadeId ? EloquentEspecialidade::find($especialidade->especialidadeId) : new EloquentEspecialidade();

        $eloquentEspecialidade->descricao = $especialidade->descricao;

        $eloquentEspecialidade->data_atualizacao = now();

        $eloquentEspecialidade->save();

        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
    }
}