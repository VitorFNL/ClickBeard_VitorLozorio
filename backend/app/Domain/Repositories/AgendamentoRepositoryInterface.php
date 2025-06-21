<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Agendamento;
use Date;

interface AgendamentoRepositoryInterface
{
    /**
     * @return Agendamento[]
     */
    public function findByDate(Date $data_agendamento): array;
    /**
     * @return Agendamento[]
     */
    public function findByBarbeiro(int $barbeiroId): array;
    /**
     * @return Agendamento[]
     */
    public function findByEspecialidade(int $especialidadeId): array;
    /**
     * @return Agendamento[]
     */
    public function findAll(): array;
    public function findById(int $agendamentoId): ?Agendamento;
    public function salvar(Agendamento $agendamento): Agendamento;
}