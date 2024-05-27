<?php

declare(strict_types=1);

namespace App\Repository\Actions;

use App\Data\Credentials;
use App\Http\Resources\StaffResource;
use App\Models\Users\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticateStaffAction
{
    public function execute(Credentials $credentials): array
    {
        $user = Staff::query()
            ->where('email', $credentials->email)
            ->whereNotNull('pos_account_id')
            ->first();
        if (!$user) {
            throw ValidationException::withMessages(['_' => __('auth.not-connected')]);
        }
        logger($user);
        if (!Hash::check($credentials->password, $user->password)) {
            throw ValidationException::withMessages(['_' => __('auth.failed')]);
        }
        $token = $user->createToken("{$user->first}-{$user->last}-token");
        $user->update([
            'last_login_at' => now('Africa/Nairobi'),
            'last_login_ip' => request()->ip(),
        ]);
        generateLoginLog($user);
        customLog(Staff::class, $user, 'logged in');

        return StaffResource::make($user)->format(StaffResource::LOGIN)->login($token->plainTextToken);
    }
}
