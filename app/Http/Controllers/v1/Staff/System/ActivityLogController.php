<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Staff\System;

use Illuminate\Http\JsonResponse;
use App\Models\System\ActivityLog;
use App\Models\System\Modification;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Contracts\ActivityLogInterface;

class ActivityLogController extends Controller
{
    public function __construct(private readonly ActivityLogInterface $activityLogRepository)
    {
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', ActivityLog::class);
        $activityLog = $this->activityLogRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $activityLog, ActivityLog::class);
    }

    public function show(ActivityLog $activityLog): JsonResponse
    {
        $this->authorize('view', [Modification::class, $activityLog->id]);
        $activityLog = $this->activityLogRepository->get($activityLog);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $activityLog, Modification::class);
    }

    public function destroy(ActivityLog $activityLog): JsonResponse
    {
        $this->authorize('delete', [ActivityLog::class, $activityLog->id]);
        $this->activityLogRepository->delete($activityLog);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }
}
