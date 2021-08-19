<?php

namespace App\Http\Controllers\Ui;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Ui\ContactEmailRequest;

class UiController extends Controller
{
    public function contactEmail(ContactEmailRequest $request)
    {
        try {
            $user = [
                'email'=> $request->email,
                'name'=> $request->name,
                'message' => $request->message
            ];
            var_dump($user);
            return response()->json([
                'ok' => true,
                'message' => $user
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
