<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Permission::class);
        $perms = $this->indexResource(Permission::class, PermissionResource::class);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $perms, Permission::class);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);
    }

    public function show(Permission $permission)
    {
        $this->authorize('view', Permission::class);
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', Permission::class);
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', Permission::class);
    }
}
