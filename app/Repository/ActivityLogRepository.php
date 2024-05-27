<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Resources\ActivityLogResource;
use App\Models\System\ActivityLog;
use App\Repository\Contracts\ActivityLogInterface;

class ActivityLogRepository extends BaseRepository implements ActivityLogInterface
{
    public function getAll()
    {
        return $this->indexResource(ActivityLog::class, ActivityLogResource::class);
    }

    public function delete(ActivityLog|string $activityLog): bool
    {
        if (!($activityLog instanceof ActivityLog)) {
            $activityLog = ActivityLog::findOrFail($activityLog);
        }

        return $activityLog->delete();
    }

    public function get(ActivityLog|string $activityLog): ActivityLogResource
    {
        if (!($activityLog instanceof ActivityLog)) {
            $activityLog = ActivityLog::findOrFail($activityLog);
        }

        return ActivityLogResource::make($activityLog);
    }
}
