<?php

use App\Http\Controllers\CadastraBarbeiroController;
use App\Http\Controllers\CadastraEspecialidadeController;
use App\Http\Controllers\ListaAgendamentosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrarUsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', RegistrarUsuarioController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::post('/agendamentos', ListaAgendamentosController::class);
    
    Route::middleware('admin')->group(function () {
        Route::post('/cadastrarBarbeiro', CadastraBarbeiroController::class);

        Route::post('/cadastrarEspecialidade', CadastraEspecialidadeController::class);
    });
});
