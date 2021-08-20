<?php

namespace App\Http\Controllers\Ui;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Ui\ContactEmailRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Ui\ContactNotification;

class UiController extends Controller
{
    public function contactEmail(ContactEmailRequest $request)
    {
        try {
            $user = array(
                'email'=> $request->email,
                'name'=> $request->name,
                'message' => $request->message
            );


            Notification::route('mail',  env('CONTACT_DESTINATION_EMAIL'))->notify(new ContactNotification($user));
            //Notification::send($request->email, new ContactNotification($request->name));

            return response()->json([
                'ok' => true,
                'message' => 'Mensaje enviado con exito'
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
