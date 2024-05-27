<?php

declare(strict_types=1);

namespace App\Repository;

use App\Data\Credentials;
use App\Http\Resources\StaffResource;
use App\Models\Users\Staff;
use App\Repository\Actions\AuthenticateStaffAction;
use App\Repository\Contracts\StaffInterface;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class StaffRepository extends BaseRepository implements StaffInterface
{
    use HasEvents;

    public function getAll()
    {
        return $this->indexResource(Staff::class, StaffResource::class);
    }

    public function get(Staff|string $staff): Staff
    {
        if (!($staff instanceof Staff)) {
            $staff = Staff::query()->findOrFail($staff);
        }

        return $staff;
    }

    public function login(Credentials $credentials): array
    {

        return make(AuthenticateStaffAction::class)
            ->execute($credentials)
            ?? throw ValidationException::withMessages(['_' => __('auth.failed')]);
    }

    public function create(array $payload): Staff
    {
        $staff = Staff::firstOrCreate($payload);
        if (array_key_exists('image', $payload)) {
            $imageName = $staff->id_number.'.jpg';

            $folderLocation = '/storage/images/staff/';

            $path = public_path($folderLocation);
            deleteOldImage($path, $staff->id_number);
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            Image::make($payload['image'])->encode('jpg', 100)->fit(800, 530)->save($path.$imageName);

            $staff->image = url($folderLocation.$imageName);
            $staff->save();
        }

        return $staff;
    }

    public function logout($request): bool
    {
        $staff = Staff::firstWhere('accessKey', $request['accessKey']);
        if (!$staff) {
            return false;
        }
        $staff->update([
            'accessKey' => null,
            'accessSecret' => null,
        ]);

        return true;
    }

    public function update(Staff|string $staff, array $payload): Staff
    {
        if (!($staff instanceof Staff)) {
            $staff = Staff::query()->findOrFail($staff);
        }
        $staff->update($payload);
        $staff->load('department');
        $staff->save();

        return $staff;
    }

    public function delete(Staff|string $staff): bool
    {
        if (!($staff instanceof Staff)) {
            $staff = Staff::query()->findOrFail($staff);
        }

        return $staff->delete();
    }
}
