<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class MeetingResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'title' => $this->resource->title,
            'conference' => $this->resource->conference,
            'link' => $this->resource->link,
            'location' => $this->resource->location,
            'status' => $this->resource->status,
            'description' => $this->resource->description,
            'owner_id' => $this->resource->owner_id,
            'owner' => $this->owner->full_name,
            // 'meetingable' =>$this->resource->meetingable,
            'meetingable' => [
                'type' => class_basename($this->meetingable_type),  // Extracts simple class name
                'details' => $this->meetingable,
            ],
            'folders' => $this->resource->folders,
            'agendas' => $this->resource->agendas,
            'attendances' => $this->resource->attendances,
            'schedule' => $this->resource->schedule,
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