<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Staff\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Users\Staff;
use App\Repository\Contracts\StaffInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StaffController extends Controller
{
    public function __construct(private readonly StaffInterface $staffRepository)
    {
    }

    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Staff::class);
        $staff = $this->staffRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $staff, Staff::class);
    }

    public function show(Staff $staff): JsonResponse
    {
        $this->authorize('view', [Staff::class, $staff->id]);
        $staff = $this->staffRepository->get($staff);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $staff, Staff::class);
    }

    public function store(CreateStaffRequest $request): JsonResponse
    {
        $this->authorize('create', [Staff::class]);
        $staff = $this->staffRepository->create($request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $staff);
    }

    public function update(UpdateStaffRequest $request, Staff $staff): JsonResponse
    {
        $this->authorize('update', [Staff::class, $staff->id]);
        $staff = $this->staffRepository->update($staff, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $staff);
    }

    public function destroy(Staff $staff): JsonResponse
    {
        $this->authorize('delete', [Staff::class, $staff->id]);
        $this->staffRepository->delete($staff);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }
}
