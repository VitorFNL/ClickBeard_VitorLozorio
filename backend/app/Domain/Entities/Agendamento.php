<?php

namespace App\Domain\Entities;

use App\Domain\Enums\StatusAgendamentoEnum;

class Agendamento
{
    public function __construct(
        public Usuario $usuario,
        public Barbeiro $barbeiro,
        public Especialidade $especialidade,
        public \DateTime $dataAgendamento,
        public \DateTime $horaInicio,
        public \DateTime $horaFim,
        public StatusAgendamentoEnum $status,
        public ?int $agendamentoId = null,
        public ?\DateTime $dataCriacao = null,
        public ?\DateTime $dataAtualizacao = null
    ) {}
}