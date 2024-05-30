<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Staff\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePasswordChangeRequest;
use App\Http\Requests\CreatePasswordResetRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CitizenResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Users\Citizen;
use App\Repository\Actions\AuthenticateAction;
use App\Repository\Contracts\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private readonly UserInterface $userRepository)
    {
    }

    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', User::class);
        $user = $this->userRepository->getUsers();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $user, User::class);
    }

    public function register(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->register($request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.registration-successful'), $user);
    }

    public function trylogin(LoginRequest $request): JsonResponse
    {
        $user = make(AuthenticateAction::class)
            ->execute($request->credentials(), new User(), UserResource::class, UserResource::LOGIN)
            ?? throw ValidationException::withMessages(['_' => __('auth.failed')]);

        return $this->response(
            status: Response::HTTP_OK,
            message: __('messages.login-successful'),
            data: $user,
        );
    }

    public function logout(Request $request): JsonResponse
    {
        //        $this->authorize('update', [User::class, $request->user()->id]);
        $this->userRepository->logout($request);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.logout-successful'), null, User::class);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', [User::class, $user->id]);
        $user = $this->userRepository->getUserFullDetails($user);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $user, User::class);
    }



    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', [User::class, $user->id]);
        $user = $this->userRepository->update($user, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $user);
    }

    public function forgotPassword(CreatePasswordResetRequest $request): JsonResponse
    {
        // dd($request);
        $this->userRepository->forgotPassword($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.password-forgot'), 'Forget password initiated');
    }
    public function changePassword(CreatePasswordChangeRequest $request): JsonResponse
    {
        $user = $this->userRepository->changePassword($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.password-changed'), $user);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', [User::class, $user->id]);
        $deletedUser = $this->userRepository->deleteUser($user);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), $deletedUser);
    }

    public function auth(Request $request): JsonResponse
    {
        if ($request->user()) {
            $user = $request->user();
            if ($user instanceof User) {
                $user = UserResource::make($user);

                return $this->response(Response::HTTP_OK, __('messages.login-successful'), $user);
            }
            if ($user instanceof Citizen) {
                $user = CitizenResource::make($user);

                return $this->response(Response::HTTP_OK, __('messages.login-successful'), $user);
            }
            //            $user['permissions'] = Arr::flatten($user->roles->map(fn($role) => $role->permissions));

            return $this->response(Response::HTTP_OK, __('messages.login-successful'), $user);
        }

        return $this->response(Response::HTTP_UNAUTHORIZED, __('messages.unauthorized'), null);
    }
}
