<?php

use App\Http\Controllers\ListaAgendamentosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrarUsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', RegistrarUsuarioController::class);
Route::post('/login', LoginController::class);

Route::post('/logout', LogoutController::class)->middleware('auth');
Route::post('/agendamentos', ListaAgendamentosController::class)->middleware('auth');
