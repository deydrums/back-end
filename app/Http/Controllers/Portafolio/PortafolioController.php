<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Portafolio\NewProjectRequest;

class PortafolioController extends Controller
{
    public function createProject(NewProjectRequest $request)
    {
        try {
            return response()->json([
                'ok' => true,
                'message' => 'Proyecto creado',
            ], 200);

        } catch (\Exception $exception) {

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'ok' => false,
            'message' => 'Ha ocurrido un error, intenta de nuevo',
        ], 401);

    }
}
