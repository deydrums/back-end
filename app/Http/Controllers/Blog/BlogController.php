<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\Traits\HasToShowApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Blog\NewEntryRequest;
use App\Http\Requests\Blog\MyEntryRequest;
use App\Http\Requests\Blog\EntryRequest;
use App\Models\Entry;


class BlogController extends Controller
{
    use HasToShowApiTokens;

    public function createEntry(NewEntryRequest $request)
    {
        try {
            $user = Auth::user();

            $entry = Entry::create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'user_id' => $user->id
            ]);


            return response()->json([
                'ok' => true,
                'message' => 'Entrada creada',
                'entry' => $entry,
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

    public function getEntries(Request $request)
    {
        try {

            return response()->json([
                'entries' => Entry::with(['user','category'])->orderBy('created_at' , 'desc')->paginate(6),
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

    public function getEntry(EntryRequest $request)
    {
        try {
            $entry = $request->getEntry($request);

            if($entry){
                return response()->json([
                    'ok' => true,
                    'message' => 'Entrada',
                    'entry' => $entry->load(['user','category'])
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'La entrada no existe'
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


    public function deleteEntry(MyEntryRequest $request)
    {
        try {
            $entry = $request->getEntry($request);

            if($entry){
                $entry->delete();
                return response()->json([
                    'ok' => true,
                    'message' => 'Entrada borrada satisfactoriamente'
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes eliminar la entrada'
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

    public function updateEntry(MyEntryRequest $request, NewEntryRequest $req)
    {
        try {
            $entry = $request->getEntry($request);
            
            if($entry){
                $entry->update([
                    'title' => $request->get('title'),
                    'content' => $request->get('content'),
                ]);
                return response()->json([
                    'ok' => true,
                    'message' => 'Entrada actualizada satisfactoriamente',
                    'entry' => $entry->load('user'),
                ], 200);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => 'No puedes eliminar la entrada'
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


