<?php

namespace App\UseCases\ListarAgendamentos;

use App\Domain\Repositories\AgendamentoRepositoryInterface;

class ListarAgendamentos implements ListarAgendamentosInterface
{
    public function __construct(
        private AgendamentoRepositoryInterface $agendamentoRepository
    ) {}

    public function execute(ListarAgendamentosInput $input): ListarAgendamentosOutput
    {
        // Filtrar por data se fornecida
        if($input->data) {
            $agendamentos = $this->agendamentoRepository->findByDate($input->data);
            return new ListarAgendamentosOutput($agendamentos);
        }

        // Filtrar por barbeiro se fornecido
        if($input->barbeiroId) {
            $agendamentos = $this->agendamentoRepository->findByBarbeiro($input->barbeiroId);
            return new ListarAgendamentosOutput($agendamentos);
        }

        // Filtrar por especialidade se fornecida
        if($input->especialidadeId) {
            $agendamentos = $this->agendamentoRepository->findByEspecialidade($input->especialidadeId);
            return new ListarAgendamentosOutput($agendamentos);
        }

        // Se for admin, pode ver todos os agendamentos
        if($input->admin) {
            $agendamentos = $this->agendamentoRepository->findAll();
            return new ListarAgendamentosOutput($agendamentos);
        }

        // Se não for admin, só pode ver seus próprios agendamentos

        $agendamentos = $this->agendamentoRepository->findByUsuario($input->usuarioId);
        return new ListarAgendamentosOutput($agendamentos);
    }
}