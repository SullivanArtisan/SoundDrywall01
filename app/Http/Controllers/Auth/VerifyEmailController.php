<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        Log::Info("---- 1 ----");
        if ($request->user()->hasVerifiedEmail()) {
            Log::Info("---- 2 ----");
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            Log::Info("---- 3 ----");
            event(new Verified($request->user()));
        }

        Log::Info("---- 4 ----");
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
