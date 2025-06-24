<?php

namespace App\UseCases\ListarEspecialidades;

class ListarEspecialidadesInput
{
    public function __construct(
        // Para especialidades, geralmente não há filtros específicos, mas mantemos consistência
        public bool $isAdmin = false,
    ) {}
}
