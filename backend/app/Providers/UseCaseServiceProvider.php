<?php

namespace App\Providers;

use App\UseCases\RegistrarUsuario\RegistrarUsuario;
use App\UseCases\RegistrarUsuario\RegistrarUsuarioInterface;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegistrarUsuarioInterface::class, RegistrarUsuario::class);
    }
}
