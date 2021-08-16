<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Traits\HasToShowApiTokens;
use App\Http\Requests\user\auth\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UpdateController extends Controller
{
    use HasToShowApiTokens;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UpdateUserRequest $request)
    {
        try {

            /** @var User $user */
            
            $user = Auth::user();
            User::where('id',$user->id)->update([
                'name' => $request->get('name'),
            ]);

            return response()->json([
                'message' =>  __('api-auth.user_update'),
            ], 200);

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }
}
