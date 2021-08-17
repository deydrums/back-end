<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Blog\NewCategoryRequest;
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

}
