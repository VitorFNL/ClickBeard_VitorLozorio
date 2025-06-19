<?php

namespace App\Providers;


use App\Domain\Repositories\UsuarioRepositoryInterface;
use App\Infrastructure\Persistence\EloquentUsuarioRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsuarioRepositoryInterface::class, EloquentUsuarioRepository::class);
    }
}
