<?php

namespace App\Providers;

use App\UseCases\CadastrarAgendamento\CadastrarAgendamento;
use App\UseCases\CadastrarAgendamento\CadastrarAgendamentoInterface;
use App\UseCases\CadastrarBarbeiro\CadastrarBarbeiro;
use App\UseCases\CadastrarBarbeiro\CadastrarBarbeiroInterface;
use App\UseCases\CadastrarEspecialidade\CadastrarEspecialidade;
use App\UseCases\CadastrarEspecialidade\CadastrarEspecialidadeInterface;
use App\UseCases\CancelarAgendamento\CancelarAgendamento;
use App\UseCases\CancelarAgendamento\CancelarAgendamentoInterface;
use App\UseCases\ListarAgendamentos\ListarAgendamentos;
use App\UseCases\ListarAgendamentos\ListarAgendamentosInterface;
use App\UseCases\ListarBarbeiros\ListarBarbeiros;
use App\UseCases\ListarBarbeiros\ListarBarbeirosInterface;
use App\UseCases\Login\Login;
use App\UseCases\Login\LoginInterface;
use App\UseCases\RegistrarUsuario\RegistrarUsuario;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInterface;
use App\UseCases\VincularEspecialidadesBarbeiro\VincularEspecialidadesBarbeiro;
use App\UseCases\VincularEspecialidadesBarbeiro\VincularEspecialidadesBarbeiroInterface;
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

        $this->app->bind(CadastrarAgendamentoInterface::class,CadastrarAgendamento::class);

        $this->app->bind(CancelarAgendamentoInterface::class, CancelarAgendamento::class);
    }
}
