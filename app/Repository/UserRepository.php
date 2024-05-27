<?php

declare(strict_types=1);

namespace App\Repository;

use App\Data\Credentials;
use App\Enums\ChangePasswordEnum;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\System\Otp;
use App\Models\User;
use App\Notifications\PasswordChangeRequestNotification;
use App\Repository\Actions\AuthenticateAction;
use App\Repository\Contracts\UserInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class UserRepository extends BaseRepository implements UserInterface
{
    public function relationships()
    {
        return [
            'profile',
            'roles.permissions',
            'membs.board',
            'membs.committee',
            ];
    }
    public function register($payload): User
    {
        $user = User::firstOrCreate($payload);
        event(new Registered($user));

        return $user;
    }

    public function login(Credentials $credentials): array
    {
        return make(AuthenticateAction::class)
            ->execute($credentials, new User(), UserResource::class, UserResource::LOGIN)
            ?? throw ValidationException::withMessages(['_' => __('auth.failed')]);
    }

    public function logout($request): mixed
    {
        return $request->user()->tokens()->delete();
    }

    public function getUsers()
    {
        $filters = [
            // 'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
            ];
        return $this->indexResource(User::class, UsersResource::class, $filters);
    }

    public function get($user): mixed
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        return $user;
    }

    public function getUserFullDetails(User|string $user): User|string
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        return $user;
    }

    public function deleteUser(User $user): ?bool
    {
        $user->roles->each(function ($role) {
            $role->users()->detach($role->id);
        });

        return $user->delete();
    }

    public function forgotPassword(array $payload): Model
    {
        $user = User::where('id_number', $payload['id_number'])
            ->firstOrFail();
        $otp = $this->generateOTP($user);
        customLog(User::class, $user, 'password reset request');
        $user->notify(new PasswordChangeRequestNotification($user));

        return $otp;
    }

    private function generateOTP($user)
    {
        return $user->otps()->create([
            'otp' => generateRandomIntString(6),
            'token' => generateRandomString(25),
            'expires_at' => now('Africa/Nairobi')->addMinutes(10),
        ]);
    }

    public function changePassword(array $payload): UserResource
    {
        $changeRequest = $this->otpIsValid($payload['otp']);
        $user = $changeRequest->otpable;
        $user->update([
            'password' => $payload['password'],
        ]);
        $user->fresh();
        $user->passwordHistories()->create(
            [
                'password' => $user->password,
                'start_date' => now('Africa/Nairobi'),
                'change_reason' => ChangePasswordEnum::Forgot,
                'end_date' => now('Africa/Nairobi')->addMonths(3),
            ]
        );
        customLog(User::class, $user, 'password reset');

        return UserResource::make($user);
    }

    private function otpIsValid(string $otp): Otp|Model
    {
        $changeRequest = Otp::where('otp', $otp)
            ->whereBetween('created_at', [now('Africa/Nairobi')->subMinutes(10), now('Africa/Nairobi')])
            ->first();
        if (!$changeRequest) {
            throw new AuthorizationException('OTP Expired');
        }

        return $changeRequest;
    }

    public function update(User|string $user, $payload): User|string
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        $user->update($payload);
        $user->save();

        return $user;
    }
}
