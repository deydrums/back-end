<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Traits\HasToShowApiTokens;
use App\Http\Requests\user\auth\RegisterRequest;
use App\Notifications\user\auth\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class RegisterController extends Controller
{
    use HasToShowApiTokens;

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function __invoke(RegisterRequest $request)
    {
        try {
            $user = $request->user();

            /** @var User $user */
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => '_USER',
            ]);

            if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->notify(new VerifyEmailNotification);
            }

            return $this->showCredentials($user, 201, config('api-auth.show_token_after_register'));

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }
}
