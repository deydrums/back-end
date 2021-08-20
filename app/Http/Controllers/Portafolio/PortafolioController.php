<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Portafolio\NewProjectRequest;
use App\Http\Requests\Portafolio\ProjectRequest;
use App\Http\Requests\user\auth\UploadImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

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

    public function uploadImage(UploadImageRequest $request, ProjectRequest $req){
        try {

            $project = $req->getProject($request);

            if($project){
                $aimage = $project->image;
                if ($aimage){
                    Storage::disk('projects')->delete($aimage);
                }
                $image = $request->file('file');
                $image_name = time().$image->getClientOriginalName();
                Storage::disk('projects')->put($image_name, File::get($image));
                $project->update([
                    'image' => $image_name,
                ]);
                return response()->json([
                    'ok' => true,
                    'message' => __('api-auth.image_upload'),
                    'filename' => $image_name,
                    'entry' => $project
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes actualizar la entrada'
                ], 401);
            }
        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }

    public function getImage($filename, $ext)
    {
        try {

            $file = Storage::disk('projects')->get($filename.'.'.$ext);

            return new Response($file,200);

        } catch (\Exception $exception) {

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'ok' => false,
            'message' => __('Error'),
        ], 401);

    }

}
