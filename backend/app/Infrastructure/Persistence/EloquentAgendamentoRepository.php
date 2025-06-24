<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Agendamento;
use App\Domain\Repositories\AgendamentoRepositoryInterface;
use App\Infrastructure\Persistence\Mappers\AgendamentoMapper;
use App\Infrastructure\Persistence\Mappers\BarbeiroMapper;
use App\Infrastructure\Persistence\Mappers\EspecialidadeMapper;
use App\Infrastructure\Persistence\Mappers\UsuarioMapper;
use App\Models\EloquentAgendamento;
use DateTime;

class EloquentAgendamentoRepository implements AgendamentoRepositoryInterface
{
    /**
     * @return Agendamento[]
     */
    public function findByDate(DateTime $data_agendamento): array
    {
        $eloquentAgendamentos = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                ->where('data_agendamento', '>=', $data_agendamento)
                                                ->orderBy('data_agendamento')
                                                ->orderBy('hora_inicio')
                                                ->get();

        return array_map(function ($eloquentAgendamento) {
            return $this->convertEloquentToDomain($eloquentAgendamento);
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
            return $this->convertEloquentToDomain($agendamento);
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
            return $this->convertEloquentToDomain($agendamento);
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
            return $this->convertEloquentToDomain($agendamento);
        }, $agendamentos->all());
    }
    public function findById(int $agendamentoId): ?Agendamento
    {
        $eloquentAgendamento = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                ->where('agendamento_id', $agendamentoId)
                                                ->first();

        if (!$eloquentAgendamento) {
            return null;
        }

        return $this->convertEloquentToDomain($eloquentAgendamento);
    }
    public function salvar(Agendamento $agendamento): Agendamento
    {
        if(!$agendamento->agendamentoId) {
            $eloquentAgendamento = AgendamentoMapper::domainToEloquent($agendamento);
            $eloquentAgendamento->save();
            
            $eloquentAgendamentoRecarregado = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                                ->find($eloquentAgendamento->agendamento_id);

            return $this->convertEloquentToDomain($eloquentAgendamentoRecarregado);
        }
        
        $eloquentAgendamento = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                ->where('agendamento_id', $agendamento->agendamentoId)
                                                ->first();

        if (!$eloquentAgendamento) {
            throw new \Exception("Agendamento não encontrado");
        }

        // Atualizar os dados do agendamento existente
        $eloquentAgendamento = AgendamentoMapper::domainToEloquent($agendamento, $eloquentAgendamento);
        $eloquentAgendamento->data_atualizacao = now();

        $eloquentAgendamento->save();

        // Recarregar com as relações para retornar
        $eloquentAgendamentoRecarregado = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                                            ->find($eloquentAgendamento->agendamento_id);

        return $this->convertEloquentToDomain($eloquentAgendamentoRecarregado);
    }

    /**
     * @return Agendamento[]
     */
    public function findByUsuario(int $usuarioId): array
    {
        $agendamentos = EloquentAgendamento::with(['usuario', 'barbeiro.especialidades', 'especialidade'])
                                        ->where('usuario_id', $usuarioId)
                                        ->orderBy('data_agendamento')
                                        ->orderBy('hora_inicio')
                                        ->get();


        return array_map(function ($agendamento) {
            return $this->convertEloquentToDomain($agendamento);
        }, $agendamentos->all());
    }

    /**
     * Converte um EloquentAgendamento para uma entidade de domínio Agendamento
     */
    private function convertEloquentToDomain($eloquentAgendamento): Agendamento
    {
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
    }
}