<?php

use App\Http\Controllers\RegistrarUsuarioController;
use App\Http\Requests\RegistrarUsuarioRequest;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', function (RegistrarUsuarioRequest $request) {
    $controller = app()->make(RegistrarUsuarioController::class);
    return $controller->__invoke($request);
});