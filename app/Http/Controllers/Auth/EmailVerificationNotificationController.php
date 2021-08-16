<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\user\auth\VerifyEmailNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function __invoke(Request $request)
    {
        if ($request->user('sanctum')->hasVerifiedEmail()) {
            return response(['message'=> __('api-auth.email_already_verified')]);
        }

        $request->user('sanctum')->notify(new VerifyEmailNotification);

        return response()->json([
            'message' => __('api-auth.email_sent'),
        ], 200);
    }


}
