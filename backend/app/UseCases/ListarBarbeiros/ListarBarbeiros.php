<?php

namespace App\UseCases\ListarBarbeiros;

use App\Domain\Repositories\BarbeiroRepositoryInterface;

class ListarBarbeiros implements ListarBarbeirosInterface
{
    public function __construct(
        private readonly BarbeiroRepositoryInterface $barbeiroRepository
    ) {}

    public function execute(ListarBarbeirosInput $input): ListarBarbeirosOutput
    {
        if ($input->especialidadeId && (!$input->data || !$input->hora)) {
            throw new \Exception("Filtos não fornecidos corretamente.", 400);
        }

        if (!$input->isAdmin && !$input->especialidadeId) {
            throw new \Exception("Usuário não autorizado a listar todos os barbeiros.", 403);
        }

        // filtrar disponíveis por especialidade, data e hora
        if ($input->especialidadeId) {
            $data = $input->data->format('Y-m-d');
            $hora = $input->hora->format('H:i');
            $barbeiros = $this->barbeiroRepository->findDisponiveis($input->especialidadeId, $data, $hora);

            return new ListarBarbeirosOutput($barbeiros);
        }

        // Se for um admin e não houver filtros, retorna todos os barbeiros ativos
        $barbeiros = $this->barbeiroRepository->findAll();

        return new ListarBarbeirosOutput($barbeiros);
    }
}