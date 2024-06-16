<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Repository\Contracts\UsersInterface;
use App\Http\Requests\UpdateUserRolesRequest;
use App\Http\Requests\CreateInviteAcceptanceRequest;

class UsersController extends Controller
{
    public function __construct(
        private readonly UsersInterface $usersRepository
    ) {
    }

    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', User::class);
        $user = $this->usersRepository->getUsers();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $user, User::class);
    }
    public function trashedusers(): JsonResponse
    {
        // $this->authorize('viewAny', User::class);
        $user = $this->usersRepository->getTrashedUsers();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $user, User::class);
    }
    public function show(User $user): JsonResponse
    {
        // $this->authorize('view', [User::class, $user->id]);
        $user = $this->usersRepository->getUserFullDetails($user);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $user, User::class);
    }
    public function store(CreateUsersRequest $request): JsonResponse
    {
        // $this->authorize('update', [User::class, $user->id]);
        $user = $this->usersRepository->create($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $user);
    }
    public function inviteaccept(CreateInviteAcceptanceRequest $request, $token): JsonResponse
    {
        // $this->authorize('update', [User::class, $user->id]);
        $user = $this->usersRepository->InviteAcceptance($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $user);
    }
    public function update(UpdateUsersRequest $request, User $user): JsonResponse
    {
        // dd($request, $user);
        // $this->authorize('update', [User::class, $user->id]);
        $user = $this->usersRepository->update($user, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $user);
    }
    public function updaterole(UpdateUserRolesRequest $request, User $user): JsonResponse
    {
        // dd($request, $user);
        // $this->authorize('update', [User::class, $user->id]);
        $user = $this->usersRepository->updateRole($user, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $user);
    }
    public function restore($user): JsonResponse
    {
        $restored = $this->usersRepository->restoreUser($user);

        if ($restored) {
            return $this->response(Response::HTTP_OK, __('messages.record-restored'), $user);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, __('messages.record-not-restored'));
    }

    public function force($user): JsonResponse
    {
        try {
            $deletedUser = $this->usersRepository->forceDeleteUser($user);
            return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), $deletedUser, User::class);
        } catch (\Exception $e) {
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function destroy($user): JsonResponse
    {
        try {
            $deletedUser = $this->usersRepository->deleteUser($user);
            return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), $deletedUser);
        } catch (\Exception $e) {
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}