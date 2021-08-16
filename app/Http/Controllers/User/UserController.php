<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Traits\HasToShowApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HasToShowApiTokens;


    public function getUsers(Request $request)
    {
        try {

            return response()->json([
                'users' => User::paginate(4)
            ], 200);

        } catch (\Exception $exception) {

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'ok' => false,
            'message' => __('Error'),
        ], 401);

    }


    public function getAvatar($filename, $ext)
    {
        try {

            $file = Storage::disk('users')->get($filename.'.'.$ext);

            return new Response($file,200);

        } catch (\Exception $exception) {

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'ok' => false,
            'message' => __('Error'),
        ], 401);

    }


    public function setAdmin(Request $request, $id, $action)
    {
        try {

            $user = User::where('id', $id)->where('id', '!=', $request->user()->id);

            if($user ->doesntExist()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            if($action === 'set'){
                $user->update([
                    'role' => '_ADMIN'
                ]);
            }else if($action === 'unset'){
                $user->update([
                    'role' => '_USER'
                ]);
            }

            return response()->json([
                'ok' => true,
                'message' => 'Role cambiado',
                'user' => $user->get()->first()
            ], 200);

        } catch (\Exception $exception) {

            return response()->json([
                'ok' => false,
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'ok' => false,
            'message' => __('Error'),
        ], 401);

    }

}
