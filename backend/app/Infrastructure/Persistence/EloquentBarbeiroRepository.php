<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Barbeiro;
use App\Domain\Repositories\BarbeiroRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\BarbeiroMapper;
use App\Infrastructure\Persistence\Mappers\EspecialidadeMapper;
use App\Models\EloquentBarbeiro;
use DateTimeImmutable;

class EloquentBarbeiroRepository implements BarbeiroRepositoryInterface
{
    public function findById(int $barbeiroId): ?Barbeiro
    {
        $barbeiro = EloquentBarbeiro::find($barbeiroId);

        if (!$barbeiro) {
            return null;
        }

        return BarbeiroMapper::EloquentToDomain($barbeiro);
    }

    public function findByNome(string $nome): array
    {
        $barbeiros = EloquentBarbeiro::where('ativo', true)
                                    ->whereLike('nome', $nome)
                                    ->get();

        if ($barbeiros->isEmpty()) {
            return [];
        }

        $barbeiros = $barbeiros->map(function ($barbeiro) {
            return BarbeiroMapper::EloquentToDomain($barbeiro);
        });

        return $barbeiros->toArray();
    }

    public function findAll(): array
    {
        $barbeiros = EloquentBarbeiro::where('ativo', true)->get();

        if ($barbeiros->isEmpty()) {
            return [];
        }

        $barbeiros = $barbeiros->map(function ($barbeiro) {
            return BarbeiroMapper::EloquentToDomain($barbeiro);
        });

        return $barbeiros->toArray();
    }

    public function salvar(Barbeiro $barbeiro): Barbeiro
    {
        $eloquentBarbeiro = $barbeiro->barbeiroId ? EloquentBarbeiro::find($barbeiro->barbeiroId) : new EloquentBarbeiro();

        $eloquentBarbeiro = BarbeiroMapper::DomainToEloquent($barbeiro, $eloquentBarbeiro);

        $eloquentBarbeiro->data_atualizacao = now();

        $eloquentBarbeiro->save();

        return BarbeiroMapper::EloquentToDomain($eloquentBarbeiro);
    }

    public function vincularEspecialidades(int $barbeiroId, array $especialidadesIds): Barbeiro
    {
        $barbeiro = EloquentBarbeiro::find($barbeiroId);

        if (!$barbeiro) {
            throw new \Exception("Barbeiro não encontrado");
        }

        $barbeiro->especialidades()->sync($especialidadesIds);

        if(!$barbeiro->relationLoaded('especialidades')) {
            $barbeiro->load('especialidades');

        }
        
        $especialidades = $barbeiro->especialidades->map(function ($especialidade) {
            return EspecialidadeMapper::EloquentToDomain($especialidade);
        })->toArray();

        return BarbeiroMapper::EloquentToDomain($barbeiro, $especialidades);
    }

    public function findDisponiveis(int $especialidadeId, string $data, string $hora): array
    {
        
        $dataCompletaDoSlotDesejado = new DateTimeImmutable($data . ' ' . $hora);
        $horaInicioDoSlotDesejado = $dataCompletaDoSlotDesejado;
        $horaFimDoSlotDesejado = $dataCompletaDoSlotDesejado->modify('+30 minutes');

        $barbeiros = EloquentBarbeiro::with('especialidades')
            ->whereHas('especialidades', function ($query) use ($especialidadeId) {
                $query->where('barbeiros_especialidades.especialidade_id', $especialidadeId);
            })
            ->whereDoesntHave('agendamentos', function ($query) use ($data, $horaInicioDoSlotDesejado, $horaFimDoSlotDesejado) {
                $query->where('ativo', true);
                $query->where('status_agendamento', 'AGENDADO');
                $query->where('data_agendamento', $data);
                $query->where('hora_inicio', '<', $horaFimDoSlotDesejado->format('H:i:s'))
                      ->where('hora_fim', '>', $horaInicioDoSlotDesejado->format('H:i:s'));
            })
            ->get();

        if ($barbeiros->isEmpty()) {
            return [];
        }

        return $barbeiros->map(function ($eloquentBarbeiro) {
            $barbeiro = BarbeiroMapper::EloquentToDomain($eloquentBarbeiro);

            if ($eloquentBarbeiro->relationLoaded('especialidades') && $eloquentBarbeiro->especialidades) {
                $barbeiroEspecialidades = $eloquentBarbeiro->especialidades->map(function ($eloquentEspecialidade) {
                    return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                })->all();

                $barbeiro->especialidades = $barbeiroEspecialidades;
            }
            return $barbeiro;
        })->all();
    }
}