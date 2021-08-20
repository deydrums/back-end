<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Portafolio\NewProjectRequest;
use App\Http\Requests\Portafolio\ProjectRequest;
use App\Models\Project;

class PortafolioController extends Controller
{
    public function createProject(NewProjectRequest $request)
    {
        try {

            $project = Project::create([
                'name' => $request->get('name'),
                'desc' => $request->get('desc'),
                'date' => $request->get('date'),
                'responsive' => $request->get('responsive'),
                'role' => $request->get('role'),
                'link' => $request->get('link'),
                'technologies' => $request->get('technologies'),
                'image' => null,
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'Proyecto creado',
                'project' => $project
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


    public function getProjects(Request $request)
    {
        try {

            return response()->json([
                'projects' => Project::orderBy('date' , 'desc')->get(),
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


    public function updateProject(ProjectRequest $request, NewProjectRequest $req)
    {
        try {
            $project = $request->getProject($request);
            
            if($project){
                $project->update([
                    'name' => $request->get('name'),
                    'desc' => $request->get('desc'),
                    'date' => $request->get('date'),
                    'responsive' => $request->get('responsive'),
                    'role' => $request->get('role'),
                    'link' => $request->get('link'),
                    'technologies' => $request->get('technologies'),
                ]);
                return response()->json([
                    'ok' => true,
                    'message' => 'Proyecto actualizado satisfactoriamente',
                    'project' => $project
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes actualizar el proyecto'
                ], 401);
            }

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


    public function deleteProject (ProjectRequest $request)
    {
        try {
            $project = $request->getProject($request);

            if($project){
                $project->delete();
                return response()->json([
                    'ok' => true,
                    'message' => 'Proyecto borrado satisfactoriamente'
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes eliminar el proyecto'
                ], 401);
            }

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
