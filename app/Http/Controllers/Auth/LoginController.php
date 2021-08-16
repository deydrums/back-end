<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Traits\HasToShowApiTokens;
use App\Http\Requests\user\auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    use HasToShowApiTokens;

    public function __invoke(LoginRequest $request)
    {
        try {

            if(Auth::attempt($request->only(['email', 'password']))) {
                return $this->showCredentials(Auth::user());
            }

        } catch (\Exception $exception) {

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'ok' => false,
            'message' => __('api-auth.failed'),
        ], 401);

    }
}
