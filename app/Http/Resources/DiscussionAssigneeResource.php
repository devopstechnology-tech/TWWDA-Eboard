<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\DiscussionResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class DiscussionAssigneeResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'discussion_id' => $this->resource->discussion_id,
            'discussion' => new DiscussionResource($this->resource->discussion),
            'user_id' => $this->resource->user_id,
            'user' => new UserResource($this->resource->user),
            'assignee_id' => $this->resource->assignee_id,
            'assignee_type' => $this->resource->assignee_type,
            'assignable' => [
                'type' => class_basename($this->assignee_type),  // Extracts simple class name
                'details' => $this->assignable,
            ],
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
