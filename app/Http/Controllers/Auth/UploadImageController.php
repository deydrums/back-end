<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\user\auth\UploadImageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class UploadImageController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UploadImageRequest $request)
    {
        try {

            /** @var User $user */

            //Eliminar imagen anterior
            $user = Auth::user();
            $aimage = $user->image;
            if ($aimage){
                Storage::disk('users')->delete($aimage);
            }

            $image = $request->file('file');
            $image_name = time().$image->getClientOriginalName();
            Storage::disk('users')->put($image_name, File::get($image));
            
            
            User::where('id',$user->id)->update([
                'image' => $image_name,
            ]);

            return response()->json([
                'message' => __('api-auth.image_upload'),
                'filename' => $image_name
            ], 200);

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }
}
