<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class AttendanceResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'location' => $this->resource->location,
            'rsvp_status' => $this->resource->rsvp_status,
            'attendance_status' => $this->resource->attendance_status,
            'meeting_id' => $this->resource->meeting_id,
            'membership_id' => $this->resource->membership_id,
            'membership' => $this->resource->membership,
            'meeting' => $this->resource->meeting,
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
