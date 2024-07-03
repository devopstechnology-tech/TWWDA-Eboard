<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\MediaResource;
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
            'invite_status' => $this->resource->invite_status,
            'rsvp_status' => $this->resource->rsvp_status,
            'attendance_status' => $this->resource->attendance_status,
            'schedule_id' => $this->resource->schedule_id,
            'membership_id' => $this->resource->membership_id,
            'membership' => $this->resource->membership,
            'meeting' => $this->resource->meeting,
            // 'media' =>  MediaResource::collection($this->whenLoaded('media')),
            'media' => MediaResource::collection($this->resource->media ?? collect()),
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
