<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sourcetoad\RuleHelper\RuleSet;

class VerificationController extends Controller
{
    public function resend(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => RuleSet::create()->required()->string(),
        ]);
        $user = User::where('email', $request->email)->firstOrFail();
        if ($user->hasVerifiedEmail()) {
            return $this->response(Response::HTTP_OK, 'User Email already verified.', null);
        }

        $user->sendEmailVerificationNotification();

        return $this->response(Response::HTTP_OK, __('messages.email-sent'), null);
    }

    public function verify($user_id, Request $request): JsonResponse|RedirectResponse
    {
        $user = User::findOrFail($user_id);
        if (!$request->hasValidSignature()) {
            return $this->response(Response::HTTP_UNAUTHORIZED, 'Invalid/Expired url provided.', null);
        }
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect('/email-verified');
    }
}
