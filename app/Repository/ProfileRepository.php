<?php

namespace App\Repository;

use stdClass;
use App\Models\Users\Profile;
use Illuminate\Http\UploadedFile;
use App\Repository\BaseRepository;
use App\Http\Resources\ProfileResource;
use App\Repository\Actions\ImageAction;
use App\Repository\Contracts\UsersInterface;
use App\Repository\Contracts\ProfileInterface;

class ProfileRepository extends BaseRepository implements ProfileInterface
{
    private $usersRepository;

    public function getUsersRepository(): UsersInterface
    {
        // Lazily load the UsersRepository when needed
        return $this->usersRepository ??= resolve(UsersInterface::class);
    }

    // Implement the methods
    public function getProfile(Profile|string $profile): ProfileResource
    {
        if (!($profile instanceof Profile)) {
            $profile = Profile::findOrFail($profile);
        }
        // return $profile;
        return ProfileResource::make($profile);
    }

    public function create($user): Profile
    {
        $profile = Profile::firstOrCreate([
            'user_id'            => $user->id,
            'phone'              => '07' . rand(10000000, 99999999),
            'idpassportnumber'   => rand(100000, 999999),
        ]);
        return $profile;
    }

    public function update(Profile|string $profile, array $payload): ProfileResource
    {
        if (!($profile instanceof Profile)) {
            $profile = Profile::findOrFail($profile);
        }
        $peviousiconfileName = $profile->avatar;
        foreach ($payload as $key => $value) {
            // Skip updating certain keys
            if (in_array($key, ['first', 'last', 'other_names', 'email', 'password', 'name'])) {
                continue; // Skip the current iteration for these keys
            }
            // Check if it's the 'avatar' attribute and if it's a file
            if ($key === 'avatar' && is_file($value)) {
                $avatarName = $this->avatarManage($payload, $profile, $peviousiconfileName);
                $profile->update(['avatar' => $avatarName]);
            } else {
                // Check if the value is not empty
                if (!empty($value)) {
                    // Update the profile with the attribute and its value
                    $profile->update([$key => $value]);
                }
            }
        }
        $this->getUsersRepository()->update($payload['user_id'], $payload);

        return ProfileResource::make($profile);
    }
    public function userprofileupdate($user, array $payload): Profile
    {
        $profile = Profile::where('user_id', $user->id)->first();
        $profile->idpassportnumber = $payload['id_number'];
        $profile->phone            = $payload['phone'];
        $profile->save();

        return $profile;
    }

    public function avatarManage($payload, $board, $peviousfileName = null)
    {
        $avatar = $payload['avatar'] ?? null;
        if ($avatar instanceof UploadedFile && $avatar->isValid()) {
            $file = $payload['avatar'];
            $folderLocation = '/images/avatar/';
            // Create a new stdClass object
            $manupulation = new stdClass();
            // Set the properties
            $manupulation->targetHeight = 250;
            $manupulation->aspectRatio = 250 / 167;
            $manupulation->targetWidth = $manupulation->targetHeight * $manupulation->aspectRatio;

            $avatarName = make(ImageAction::class)
                ->executeAvatar($file, $folderLocation, $manupulation, $peviousfileName);
        } else {

            $avatarName = $peviousfileName;
        }
        return $avatarName;
    }
}