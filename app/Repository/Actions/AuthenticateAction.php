<?php

declare(strict_types=1);

namespace App\Repository\Actions;

use App\Data\Credentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticateAction
{
    public function execute(Credentials $credentials, $model, $resource, $format)
    {

        $user = $model::where('email', $credentials->email)->first();
        // dd($credentials, $user);
        // dd($user);
        if (!$user) {
            return null;
        }
        // dd(!Hash::check($credentials->password, $user->password));
        if (!Hash::check($credentials->password, $user->password)) {
            throw ValidationException::withMessages(['_' => __('auth.failed')]);
        }

        $token = $user->createToken("{$user->first}-{$user->last}-token");
        // dd($credentials->password, $user->password);
        $user->update([
            'last_login_at' => now('Africa/Nairobi'),
            'last_login_ip' => request()->ip(),
        ]);
        generateLoginLog($user);
        customLog($model::class, $user, 'logged in');
        // dd(Auth::user(), $user, $token);
        return $resource::make($user)->format($format)->login($token->plainTextToken);
    }
}
