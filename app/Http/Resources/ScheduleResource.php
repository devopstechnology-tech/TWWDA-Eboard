<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\MeetingResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class ScheduleResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'status' => $this->resource->status,
            'closestatus' => $this->resource->closestatus,
            'heldstatus' => $this->resource->heldstatus,
            'date' => $this->resource->date,
            'start_time' => $this->resource->start_time,
            'end_time' => $this->resource->end_time,
            'meeting_id' => $this->resource->meeting_id,
            'meeting' => $this->resource->meeting ? (new MeetingResource($this->resource->meeting)) : null,
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
        ];
    }
}
