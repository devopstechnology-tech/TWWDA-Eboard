<?php

namespace App\Http\Controllers\v1\Modules\User;

use Illuminate\Http\Request;
use App\Models\Users\Profile;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Repository\Contracts\ProfileInterface;

class ProfileController extends Controller
{
    //
    public function __construct(
        private readonly ProfileInterface $profileRepository
    ) {
    }

    public function show(Profile $profile): JsonResponse
    {
        // $this->authorize('view', [Profile::class, $profile->id]);
        $profile = $this->profileRepository->getProfile($profile);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $profile, Profile::class);
    }
    public function update(UpdateProfileRequest $request, Profile $profile): JsonResponse
    {
        // dd($request, $profile);
        // $this->authorize('update', [Profile::class, $profile->id]);
        $profile = $this->profileRepository->update($profile, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $profile);
    }
}