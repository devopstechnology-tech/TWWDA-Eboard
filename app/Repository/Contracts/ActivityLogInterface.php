<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\System\ActivityLog;
use App\Http\Resources\ActivityLogResource;

interface ActivityLogInterface
{
    public function getAll();

    public function get(ActivityLog|string $activityLog): ActivityLog|ActivityLogResource;

    public function delete(ActivityLog|string $activityLog): bool;
}
