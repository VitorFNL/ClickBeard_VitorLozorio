<?php

use App\Http\Controllers\CadastraBarbeiroController;
use App\Http\Controllers\CadastraEspecialidadeController;
use App\Http\Controllers\ListaAgendamentosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrarUsuarioController;
use App\Http\Controllers\VinculaEspecialidadesBarbeiroController;
use Illuminate\Support\Facades\Route;

Route::put('/registrar', RegistrarUsuarioController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::post('/agendamentos', ListaAgendamentosController::class);
    
    Route::middleware('admin')->group(function () {
        Route::put('/cadastrarBarbeiro', CadastraBarbeiroController::class);

        Route::put('/cadastrarEspecialidade', CadastraEspecialidadeController::class);

        Route::put('/vincularEspecialidadesBarbeiro', VinculaEspecialidadesBarbeiroController::class);
    });
});
