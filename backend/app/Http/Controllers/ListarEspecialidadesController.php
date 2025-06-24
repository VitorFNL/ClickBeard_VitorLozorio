<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\ListarEspecialidades\ListarEspecialidadesInput;
use App\UseCases\ListarEspecialidades\ListarEspecialidadesInterface;
use Illuminate\Http\Request;

class ListarEspecialidadesController extends Controller
{
    public function __construct(
        private ListarEspecialidadesInterface $listarEspecialidades
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input['user'] = $request->user;

            $response = $this->listarEspecialidades->execute(new ListarEspecialidadesInput(
                $input['user']->admin ?? false,
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Especialidades listadas com sucesso',
                'especialidades' => $response->especialidades
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
