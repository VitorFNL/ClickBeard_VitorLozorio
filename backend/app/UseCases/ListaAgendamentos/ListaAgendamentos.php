<?php

namespace App\UseCases\ListaAgendamentos;

use App\Domain\Repositories\AgendamentoRepositoryInterface;

class ListaAgendamentos implements ListaAgendamentosInterface
{
    public function __construct(
        private AgendamentoRepositoryInterface $agendamentoRepository
    ) {}

    public function execute(ListaAgendamentosInput $input): ListaAgendamentosOutput
    {
        // Filtrar por data se fornecida
        if($input->data) {
            $agendamentos = $this->agendamentoRepository->findByDate($input->data);
            return new ListaAgendamentosOutput($agendamentos);
        }

        // Filtrar por barbeiro se fornecido
        if($input->barbeiroId) {
            $agendamentos = $this->agendamentoRepository->findByBarbeiro($input->barbeiroId);
            return new ListaAgendamentosOutput($agendamentos);
        }

        // Filtrar por especialidade se fornecida
        if($input->especialidadeId) {
            $agendamentos = $this->agendamentoRepository->findByEspecialidade($input->especialidadeId);
            return new ListaAgendamentosOutput($agendamentos);
        }

        if(!$input->admin) {
            throw new \Exception("Usuário não autorizado a listar agendamentos.");
        }

        $agendamentos = $this->agendamentoRepository->findAll();

        return new ListaAgendamentosOutput($agendamentos);
    }
}