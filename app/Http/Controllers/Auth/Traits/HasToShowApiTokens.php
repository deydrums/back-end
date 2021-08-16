<?php

namespace App\Http\Controllers\Auth\Traits;
use App\Models\User;

trait HasToShowApiTokens
{
    /**
     * Here you can customize how to return data on login and register
     * @param $user
     * @param int $code
     * @param bool $showToken
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCredentials($user, $code = 200, $showToken = true)
    {
        $response = [
            'message' => __('api-auth.success'),
            'uid' => $user->id,
            'name' => $user->name,
            'email_verified_at' => $user->email_verified_at,
            'filename' => $user->image,
            'role' => $user->role,
        ];

        if($showToken) {
            $response['token'] = $this->createToken($user);
        }

        return response()->json($response, $code);
    }

    protected function createToken(User $user)
    {
        $token = $user->createToken(
            config('api-auth.token_id') ?? 'App',
            // Here you can customize the scopes for a new user
            config('api-auth.scopes')
        );

        return $token->plainTextToken;
    }
}
