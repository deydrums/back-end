<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Blog\NewCategoryRequest;
use App\Http\Requests\Blog\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function createCategory(NewCategoryRequest $request)
    {
        try {

            $category = Category::create([
                'name' => $request->get('name'),
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'Categoria creada',
                'entry' => $category,
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



    public function updateCategory(CategoryRequest $request, NewCategoryRequest $req)
    {
        try {
            $category = $request->getCategory($request);
            
            if($category){
                $category->update([
                    'name' => $request->get('name'),
                ]);
                return response()->json([
                    'ok' => true,
                    'message' => 'Categoria actualizada satisfactoriamente',
                    'category' => $category
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes actualizar la categoria'
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


    
    public function getCategories(Request $request)
    {
        try {

            return response()->json([
                'categories' => Category::all(),
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




    public function deleteCategory(CategoryRequest $request)
    {
        try {
            $category = $request->getCategory($request);

            if($category){
                $category->delete();
                return response()->json([
                    'ok' => true,
                    'message' => 'Categoria borrada satisfactoriamente'
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes eliminar la categoria'
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

    public function getCategory(CategoryRequest $request)
    {
        try {
            $category = $request->getCategory($request);

            if($category){
                return response()->json([
                    'ok' => true,
                    'message' => 'Categoria',
                    'entry' => $category->load('entries')
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'La categoria no existe'
                ], 404);
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
