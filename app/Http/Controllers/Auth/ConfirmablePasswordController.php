<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController
{
    /**
     * Confirm the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        if (! Hash::check($request->get('password'), $request->user('sanctum')->password)) {
            throw ValidationException::withMessages([
                'password' => __('api-auth.password'),
            ]);
        }

        return response()->json([
            'message' => __('api-auth.password_confirmed'),
        ], 200);
    }
}
