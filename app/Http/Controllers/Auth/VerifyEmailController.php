<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\auth\EmailVerificationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     * Just take in mind that the request needs to go directly to the server to validate the id and token
     * Because the link would be sent on the email notification
     *
     * @param EmailVerificationRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            // if block added only to test on postman.
            if($request->wantsJson()) {
                return response()->json([
                    'message' => __('api-auth.email_already_verified'),
                ], 200);
            }
            return redirect()->to(config('api-auth.email_account_was_already_verified_url'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // if block added just to test on postman.
        if($request->wantsJson()) {
            return response()->json([
                'message' => __('api-auth.email_verified'),
            ], 200);
        }
        return redirect()->to(config('api-auth.email_account_just_verified_url'));
    }
    
}
