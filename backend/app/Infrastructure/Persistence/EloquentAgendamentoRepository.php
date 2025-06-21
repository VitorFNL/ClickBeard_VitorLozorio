<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Agendamento;
use App\Domain\Repositories\AgendamentoRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\AgendamentoMapper;
use App\Infrastructure\Persistence\Mappers\BarbeiroMapper;
use App\Infrastructure\Persistence\Mappers\EspecialidadeMapper;
use App\Infrastructure\Persistence\Mappers\UsuarioMapper;
use App\Models\EloquentAgendamento;
use Date;

class EloquentAgendamentoRepository implements AgendamentoRepositoryInterface
{
    /**
     * @return Agendamento[]
     */
    public function findByDate(Date $data_agendamento): array
    {
        $eloquentAgendamentos = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                ->where('data_agendamento', '>=', $data_agendamento)
                                                ->orderBy('data_agendamento')
                                                ->orderBy('hora_inicio')
                                                ->get();

        return array_map(function ($eloquentAgendamento) {

            $usuario = UsuarioMapper::EloquentToDomain($eloquentAgendamento->usuario);
            $especialidade = EspecialidadeMapper::EloquentToDomain($eloquentAgendamento->especialidade);

            $barbeiro = null;

            if ($eloquentAgendamento->barbeiro) {
                $barbeiro = BarbeiroMapper::EloquentToDomain($eloquentAgendamento->barbeiro);

                if ($eloquentAgendamento->barbeiro->relationLoaded('especialidades')) {
                    $barbeiroEspecialidades = $eloquentAgendamento->barbeiro->especialidades->map(function ($eloquentEspecialidade) {
                        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                    })->all();

                    $barbeiro->especialidades = $barbeiroEspecialidades;
                }
            }


            return AgendamentoMapper::toDomain(
                $eloquentAgendamento,
                $usuario,
                $barbeiro,
                $especialidade
            );
            
        }, $eloquentAgendamentos->all());
    }

    /**
     * @return Agendamento[]
     */
    public function findByBarbeiro(int $barbeiroId): array
    {
        $agendamentos = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                        ->where('barbeiro_id', $barbeiroId)
                                        ->orderBy('data_agendamento')
                                        ->orderBy('hora_inicio')
                                        ->get();
        
        return array_map(function ($agendamento) {
            $usuario = UsuarioMapper::EloquentToDomain($agendamento->usuario);
            $especialidade = EspecialidadeMapper::EloquentToDomain($agendamento->especialidade);

            $barbeiro = null;

            if ($agendamento->barbeiro) {
                $barbeiro = BarbeiroMapper::EloquentToDomain($agendamento->barbeiro);

                if ($agendamento->barbeiro->relationLoaded('especialidades')) {
                    $barbeiroEspecialidades = $agendamento->barbeiro->especialidades->map(function ($eloquentEspecialidade) {
                        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                    })->all();

                    $barbeiro->especialidades = $barbeiroEspecialidades;
                }
            }

            return AgendamentoMapper::toDomain(
                $agendamento,
                $usuario,
                $barbeiro,
                $especialidade
            );
        }, $agendamentos->all());
    }

    /**
     * @return Agendamento[]
     */
    public function findByEspecialidade(int $especialidadeId): array
    {
        $agendamentos = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                        ->where('especialidade_id', $especialidadeId)
                                        ->orderBy('data_agendamento')
                                        ->orderBy('hora_inicio')
                                        ->get();

        return array_map(function ($agendamento) {
            $usuario = UsuarioMapper::EloquentToDomain($agendamento->usuario);
            $especialidade = EspecialidadeMapper::EloquentToDomain($agendamento->especialidade);

            $barbeiro = null;

            if ($agendamento->barbeiro) {
                $barbeiro = BarbeiroMapper::EloquentToDomain($agendamento->barbeiro);

                if ($agendamento->barbeiro->relationLoaded('especialidades')) {
                    $barbeiroEspecialidades = $agendamento->barbeiro->especialidades->map(function ($eloquentEspecialidade) {
                        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                    })->all();

                    $barbeiro->especialidades = $barbeiroEspecialidades;
                }
            }

            return AgendamentoMapper::toDomain(
                $agendamento,
                $usuario,
                $barbeiro,
                $especialidade
            );
        }, $agendamentos->all());
    }

    /**
     * @return Agendamento[]
     */
    public function findAll(): array
    {
        $agendamentos = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                        ->orderBy('data_agendamento')
                                        ->orderBy('hora_inicio')
                                        ->get();

        return array_map(function ($agendamento) {
            $usuario = UsuarioMapper::EloquentToDomain($agendamento->usuario);
            $especialidade = EspecialidadeMapper::EloquentToDomain($agendamento->especialidade);

            $barbeiro = null;

            if ($agendamento->barbeiro) {
                $barbeiro = BarbeiroMapper::EloquentToDomain($agendamento->barbeiro);

                if ($agendamento->barbeiro->relationLoaded('especialidades')) {
                    $barbeiroEspecialidades = $agendamento->barbeiro->especialidades->map(function ($eloquentEspecialidade) {
                        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                    })->all();

                    $barbeiro->especialidades = $barbeiroEspecialidades;
                }
            }

            return AgendamentoMapper::toDomain(
                $agendamento,
                $usuario,
                $barbeiro,
                $especialidade
            );
        }, $agendamentos->all());
    }
    public function findById(int $agendamentoId): ?Agendamento
    {
        $eloquentAgendamento = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                ->where('agendamento_id', $agendamentoId)
                                                ->get();

        if ($eloquentAgendamento->isEmpty()) {
            return null;
        }

        $agendamento = array_map(function ($agendamento) {
            $usuario = UsuarioMapper::EloquentToDomain($agendamento->usuario);
            $especialidade = EspecialidadeMapper::EloquentToDomain($agendamento->especialidade);

            $barbeiro = null;

            if ($agendamento->barbeiro) {
                $barbeiro = BarbeiroMapper::EloquentToDomain($agendamento->barbeiro);

                if ($agendamento->barbeiro->relationLoaded('especialidades')) {
                    $barbeiroEspecialidades = $agendamento->barbeiro->especialidades->map(function ($eloquentEspecialidade) {
                        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                    })->all();

                    $barbeiro->especialidades = $barbeiroEspecialidades;
                }
            }

            return AgendamentoMapper::toDomain(
                $agendamento,
                $usuario,
                $barbeiro,
                $especialidade
            );
        }, $eloquentAgendamento->all());

        return $agendamento[0];
    }
    public function salvar(Agendamento $agendamento): Agendamento
    {
        if(!$agendamento->agendamentoId) {
            $eloquentAgendamento = AgendamentoMapper::domainToEloquent($agendamento);

            $eloquentAgendamento->save();

            // TODO : Criar um mapeamento para converter o eloquent para o domínio
            return $agendamento;
        }
        
        $eloquentAgendamento = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                ->where('agendamento_id', $agendamento->agendamentoId)
                                                ->get();


        $agendamento = $eloquentAgendamento[0];

        $agendamento->save();

        $agendamento = array_map(function ($agendamento) {
            $usuario = UsuarioMapper::EloquentToDomain($agendamento->usuario);
            $especialidade = EspecialidadeMapper::EloquentToDomain($agendamento->especialidade);

            $barbeiro = null;

            if ($agendamento->barbeiro) {
                $barbeiro = BarbeiroMapper::EloquentToDomain($agendamento->barbeiro);

                if ($agendamento->barbeiro->relationLoaded('especialidades')) {
                    $barbeiroEspecialidades = $agendamento->barbeiro->especialidades->map(function ($eloquentEspecialidade) {
                        return EspecialidadeMapper::EloquentToDomain($eloquentEspecialidade);
                    })->all();

                    $barbeiro->especialidades = $barbeiroEspecialidades;
                }
            }

            return AgendamentoMapper::toDomain(
            $agendamento,
            $usuario,
            $barbeiro,
            $especialidade
            );
        }, $eloquentAgendamento->all());

        return $agendamento[0];
    }
}