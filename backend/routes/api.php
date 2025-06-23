<?php

use App\Http\Controllers\CadastrarBarbeiroController;
use App\Http\Controllers\CadastrarEspecialidadeController;
use App\Http\Controllers\ListarAgendamentosController;
use App\Http\Controllers\ListarBarbeirosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrarUsuarioController;
use App\Http\Controllers\VincularEspecialidadesBarbeiroController;
use Illuminate\Support\Facades\Route;

Route::put('/registrar', RegistrarUsuarioController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::post('/agendamentos', ListarAgendamentosController::class);

    Route::get('/barbeiros', ListarBarbeirosController::class);
    
    Route::middleware('admin')->group(function () {
        Route::put('/cadastrarBarbeiro', CadastrarBarbeiroController::class);

        Route::put('/cadastrarEspecialidade', CadastrarEspecialidadeController::class);

        Route::put('/vincularEspecialidadesBarbeiro', VincularEspecialidadesBarbeiroController::class);

    });
});
