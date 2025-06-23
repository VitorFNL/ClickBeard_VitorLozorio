<?php

namespace App\Providers;

use App\UseCases\CadastraBarbeiro\CadastraBarbeiro;
use App\UseCases\CadastraBarbeiro\CadastraBarbeiroInterface;
use App\UseCases\CadastraEspecialidade\CadastraEspecialidade;
use App\UseCases\CadastraEspecialidade\CadastraEspecialidadeInterface;
use App\UseCases\ListaAgendamentos\ListaAgendamentos;
use App\UseCases\ListaAgendamentos\ListaAgendamentosInterface;
use App\UseCases\ListarBarbeiros\ListarBarbeiros;
use App\UseCases\ListarBarbeiros\ListarBarbeirosInterface;
use App\UseCases\Login\Login;
use App\UseCases\Login\LoginInterface;
use App\UseCases\RegistrarUsuario\RegistrarUsuario;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInterface;
use App\UseCases\VinculaEspecialidadesBarbeiro\VinculaEspecialidadesBarbeiro;
use App\UseCases\VinculaEspecialidadesBarbeiro\VinculaEspecialidadesBarbeiroInterface;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegistrarUsuarioInterface::class, RegistrarUsuario::class);

        $this->app->bind(LoginInterface::class, Login::class);

        $this->app->bind(ListaAgendamentosInterface::class, ListaAgendamentos::class);

        $this->app->bind(CadastraBarbeiroInterface::class, CadastraBarbeiro::class);

        $this->app->bind(CadastraEspecialidadeInterface::class, CadastraEspecialidade::class);

        $this->app->bind(VinculaEspecialidadesBarbeiroInterface::class, VinculaEspecialidadesBarbeiro::class);

        $this->app->bind(ListarBarbeirosInterface::class, ListarBarbeiros::class);
    }
}
