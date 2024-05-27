<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repository\Contracts\RoleInterface;
use App\Traits\RequiresApproval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function __construct(private readonly RoleInterface $roleRepository)
    {
    }

    public function attachPermissionToRole(Role $role, Permission $permission): JsonResponse
    {
        $this->authorize('update', [Role::class, $role->id]);
        $role = $this->roleRepository->attachPermissionToRole($role, $permission);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $role, Role::class);
    }

    public function attachRoleToUser(Role $role, User $user): JsonResponse
    {
        $this->authorize('update', [Role::class, $role->id]);
        $role = $this->roleRepository->attachRoleToUser($role, $user);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $role, Role::class);
    }

    public function destroy(Role $role): JsonResponse
    {
        $this->authorize('delete', [Role::class, $role->id]);
        $this->roleRepository->delete($role);
        if (in_array(RequiresApproval::class, get_declared_traits())) {
            return $this->response(Response::HTTP_MULTI_STATUS, __('messages.record-deleted'), null);
        }

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }

    public function detachPermissionFromRole(Role $role, Permission $permission): JsonResponse
    {
        $this->authorize('update', [Role::class, $role->id]);
        $role = $this->roleRepository->detachPermissionFromRole($role, $permission);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $role, Role::class);
    }

    public function detachRoleFromUser(Role $role, User $user): JsonResponse
    {
        $this->authorize('update', [Role::class, $role->id]);
        $role = $this->roleRepository->detachRoleFromUser($role, $user);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $role, Role::class);
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Role::class);
        $role = $this->roleRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $role, Role::class);
    }

    public function show(Role $role): JsonResponse
    {
        $this->authorize('view', [Role::class, $role->id]);
        $role = $this->roleRepository->get($role);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $role, Role::class);
    }

    public function store(CreateRoleRequest $request): JsonResponse
    {
        $this->authorize('create', [Role::class]);
        $role = $this->roleRepository->create($request->validated());
        if (in_array(RequiresApproval::class, get_declared_traits())) {
            return $this->response(Response::HTTP_MULTI_STATUS, __('messages.record-created'), $role);
        }

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $role);
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $this->authorize('update', [Role::class, $role->id]);
        $role = $this->roleRepository->update($role, $request->validated());
        if (in_array(RequiresApproval::class, get_declared_traits())) {
            return $this->response(Response::HTTP_MULTI_STATUS, __('messages.record-updated'), $role);
        }

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $role);
    }
}
