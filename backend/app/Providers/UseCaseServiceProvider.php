<?php

namespace App\Providers;

use App\UseCases\CadastraBarbeiro\CadastraBarbeiro;
use App\UseCases\CadastraBarbeiro\CadastraBarbeiroInterface;
use App\UseCases\CadastraEspecialidade\CadastrarEspecialidade;
use App\UseCases\CadastraEspecialidade\CadastrarEspecialidadeInterface;
use App\UseCases\ListaAgendamentos\ListarAgendamentos;
use App\UseCases\ListaAgendamentos\ListarAgendamentosInterface;
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

        $this->app->bind(ListarAgendamentosInterface::class, ListarAgendamentos::class);

        $this->app->bind(CadastrarBarbeiroInterface::class, CadastrarBarbeiro::class);

        $this->app->bind(CadastrarEspecialidadeInterface::class, CadastrarEspecialidade::class);

        $this->app->bind(VincularEspecialidadesBarbeiroInterface::class, VincularEspecialidadesBarbeiro::class);

        $this->app->bind(ListarBarbeirosInterface::class, ListarBarbeiros::class);
    }
}
