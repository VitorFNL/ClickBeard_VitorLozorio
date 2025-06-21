<?php

use App\Http\Controllers\RegistrarUsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', RegistrarUsuarioController::class);