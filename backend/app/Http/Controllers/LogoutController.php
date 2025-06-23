<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $jsonResponse = response()->json([
            'status' => 'success',
            'message' => 'Logout realizado com sucesso',
        ], 200);

        $jsonResponse->withoutCookie('jwt_token');

        return $jsonResponse;
    }
}
