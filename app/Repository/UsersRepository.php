<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Role;
use App\Models\User;
use App\Traits\Types;
use App\Data\Credentials;
use App\Models\System\Otp;
use App\Enums\ChangePasswordEnum;
use App\Repository\BaseRepository;
use App\Http\Resources\UsersResource;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Contracts\UserInterface;
use App\Repository\Contracts\UsersInterface;
use App\Repository\Contracts\ProfileInterface;
use Illuminate\Auth\Access\AuthorizationException;

class UsersRepository extends BaseRepository implements UsersInterface
{
    use Types;
    private $profileRepository;
    private $userRepository;

    public function getProfileRepository(): ProfileInterface
    {
        // Lazily load the ProfileRepository when needed
        return $this->profileRepository ??= resolve(ProfileInterface::class);
    }

    public function getUserRepository(): UserInterface
    {
        // Lazily load the UsersRepository when needed
        return $this->userRepository ??= resolve(UserInterface::class);
    }
    public function relationships()
    {
        return [
            'profile',
            'roles.permissions',
            'membs.board',
            'membs.committee',
        ];
    }

    private function generateOTP($user)
    {
        return $user->otps()->create([
            'otp' => generateRandomIntString(6),
            'token' => generateRandomString(25),
            'expires_at' => now('Africa/Nairobi')->addMinutes(10),
        ]);
    }
    private function otpIsValid(string $otp): Otp|Model
    {
        $changeRequest = Otp::where('otp', $otp)
            ->whereBetween('created_at', [now('Africa/Nairobi')->subMinutes(30), now('Africa/Nairobi')])
            ->first();
        if (!$changeRequest) {
            throw new AuthorizationException('OTP Expired');
        }

        return $changeRequest;
    }
    private function tokenIsValid(string $token): Otp|Model
    {
        $changeRequest = Otp::where('token', $token)
            ->where('status', 'active')
            ->whereBetween('created_at', [now('Africa/Nairobi')->subMinutes(60), now('Africa/Nairobi')])
            ->first();
        if (!$changeRequest) {
            throw new AuthorizationException('TOKEN Expired');
        }

        return $changeRequest;
    }
    public function getUsers()
    {
        // $baseUrl = config('app.url');
        // $parsedUrl = parse_url($baseUrl);
        // $fullUrl = config('app.url');
        // dd($fullUrl);
        $filters = [
            // 'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(User::class, UsersResource::class, $filters);
    }
    public function getLatest()
    {
        $orderBy = ['field' => 'created_at', 'direction' => 'asc'];
        // Fetch the data
        $totalCount = User::count();
        $users = User::with($this->relationships())
            ->orderBy($orderBy['field'], $orderBy['direction'])
            ->limit(9)
            ->get();

            $data =  [
                'count' => $totalCount,
                'users' => $users,
            ];
            return $data;
    }


    public function getTrashedUsers()
    {
        // $baseUrl = config('app.url');
        // $parsedUrl = parse_url($baseUrl);
        // $fullUrl = config('app.url');
        // dd($fullUrl);
        $filters = [
            // 'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc'],
            'includeDeleted' => 'only', // Options are 'with', 'only', or not set (to exclude)
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
    public function getUserFullDetails(User|string $user)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        // return $user;
        return UsersResource::make($user);
    }
    public function create(array $payload): User

    {
        $user = User::withoutApproval()->firstOrCreate([
            'email' => $payload['email'],
            'role'  => $payload['role'],
            'first'  => $payload['first'],
            'last'  => $payload['last'],            
            'status' => 'invited',
            'password' => '123456789',
        ]);
        $user->markEmailAsVerified();
        $profile = $this->getProfileRepository()->create($user, $payload);
        $defaultRoles = Role::where('type', Role::$type_default)->pluck('id');
        $user->roles()->syncWithoutDetaching($defaultRoles);
        return $user;
    }

    public function InviteAcceptance(array $payload)
    {

        $changeRequest = $this->tokenIsValid($payload['token']);

        $user = $changeRequest->otpable;
        $user->update([
            'first'    => $payload['first'],
            'last'     => $payload['last'],
            'password' => $payload['password'],
        ]);
        $profile = $this->getProfileRepository()->userprofileupdate($user, $payload);
        $user->fresh();
        $defaultRoles = Role::where('type', Role::$type_default)->pluck('id');
        $user->roles()->syncWithoutDetaching($defaultRoles);
        $user->passwordHistories()->create(
            [
                'password' => $user->password,
                'start_date' => now('Africa/Nairobi'),
                'change_reason' => ChangePasswordEnum::Forgot,
                'end_date' => now('Africa/Nairobi')->addMonths(3),
            ]
        );
        $updateOtp = $this->updateOTP($payload['token']);
        $credentials = new Credentials($user->email, $payload['password']);

        return $this->getUserRepository()->login($credentials);
    }
    public function updateOTP($token)
    {
        $updateToken = Otp::where('token', $token)->first();
        $updateToken->usage_attempts += 1;
        $updateToken->status = 'inactive';
        $updateToken->save();
    }
    public function update(User|string $user, array $payload): User
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        $user->update([
            'first'       => $payload['first'],
            'last'        => $payload['last'],
            'other_names' => $payload['other_names'],
            'email'       => $payload['email'],
        ]);
        $user->fresh();
        $defaultRoles = Role::where('type', Role::$type_default)->pluck('id');
        $user->roles()->syncWithoutDetaching($defaultRoles);

        return $user;
    }
    public function updateRole(User|string $user, array $payload): User
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        // Map the role to the type
        $type = Types::mapRoleToType($payload['role']);

        // Update thse user type and role
        $user->type = $type;
        $user->role = $payload['role'];
        $user->save();
        $user->fresh();
        $role = Role::where('name', $payload['role'])->pluck('id');
        $user->roles()->sync($role);
        return $user;
    }


    public function deleteUser($user)
    {
        // Ensure we're working with the correct User instance
        $user = User::withoutApproval()->findOrFail($user);

        // Detach roles
        // $user->roles->each(function ($role) {
        //     $role->users()->detach($role->id);
        // });
        // Perform the delete operation
        $deleted = $user->delete();
        if ($deleted) {
            $user = $user->fresh();
            return !is_null($user->deleted_at);
        }

        return false;
    }
    public function forceDeleteUser($user)
    {
        $user = User::withoutApproval()->withTrashed()->findOrFail($user);

        $user->roles->each(function ($role) {
            $role->users()->detach($role->id);
        });

        $deleted = $user->forceDelete();
        return $deleted;
    }
    public function restoreUser($user)
    {
        $user = User::withoutApproval()->withTrashed()->findOrFail($user);
        $restored = $user->restore();
        if ($restored) {
            $user = $user->fresh();
            return is_null($user->deleted_at);
        }

        return false;
    }
}