<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class AgendaResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        if ($this->resource) {
            return [
                'id' => $this->resource->getRouteKey(),
                'title' => $this->resource->title,
                'description' => $this->resource->description,
                'duration' => $this->resource->duration,
                'meeting_id' => $this->resource->meeting_id,
                'meeting' => $this->resource->meeting,
                'assignees' => $this->resource->assignees,
                'children' => $this->resource->children,
            ];
        }
        // Return an empty array or default values if the resource is null
        return [];
    }


    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
        ];
    }
}