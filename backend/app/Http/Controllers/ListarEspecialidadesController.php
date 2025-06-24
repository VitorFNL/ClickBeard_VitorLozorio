<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\ListarEspecialidades\ListarEspecialidadesInput;
use App\UseCases\ListarEspecialidades\ListarEspecialidadesInterface;
use App\Infrastructure\Persistence\Mappers\EspecialidadeMapper;
use Illuminate\Http\Request;

class ListarEspecialidadesController extends Controller
{
    public function __construct(
        private ListarEspecialidadesInterface $listarEspecialidades
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $input['user'] = $request->user;            $response = $this->listarEspecialidades->execute(new ListarEspecialidadesInput(
                $input['user']->admin ?? false,
            ));

            // Converter entidades de domínio para arrays formatados
            $especialidadesArray = array_map([EspecialidadeMapper::class, 'domainToArray'], $response->especialidades);

            return response()->json([
                'status' => 'success',
                'message' => 'Especialidades listadas com sucesso',
                'especialidades' => $especialidadesArray
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro interno do servidor',
            ], $e->getCode() ?: 500);
        }
    }
}
