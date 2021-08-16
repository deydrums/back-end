<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\Revokers\SanctumRevoker;
use App\Http\Controllers\Auth\Traits\HasToShowApiTokens;

class RenewTokenController extends Controller
{
    use HasToShowApiTokens;

    public function __invoke(Request $request)
    {
        try {

            (new SanctumRevoker(Auth::user()))->{$this->applyRevokeStrategy()}();
            return $this->showCredentials(Auth::user());

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'message' => 'Ha ocurrido un error al renovar el token',
        ], 401);

    }


    public function applyRevokeStrategy()
    {
        $methods = [
            'revoke_only_current_token',
            'revoke_all_tokens',
            'delete_current_token',
            'delete_all_tokens',
        ];

        return (string) Str::of($methods[2])->camel();
    }

}
