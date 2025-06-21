<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrarUsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', RegistrarUsuarioController::class);
Route::post('/login', LoginController::class);