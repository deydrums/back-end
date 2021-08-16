<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\user\auth\ResetPasswordNotification;
use App\Http\Requests\user\auth\PasswordResetLinkRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetLinkController extends Controller
{

    /**
     * @param PasswordResetLinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(PasswordResetLinkRequest $request)
    {
        $user = $request->getUser();

        try {
            // Here you can customize the token length
            $token = Str::random(60);

            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now()
            ]);

            $user->notify(new ResetPasswordNotification($token));

            return response()->json([
                'message' => __('api-auth.check_your_email'),
            ]);

        } catch (\Exception $exception) {
            if($exception->getMessage() == 'Undefined property: Illuminate\Http\JsonResponse::$email'){
                return response()->json([
                    'message' => 'El correo electrónico no esta registrado',
                ], 400);
            }else{
                return response()->json([
                    'message' => $exception->getMessage(),
                ], 400);
            }
        }

    }
}
