<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Http\Resources\ChatResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\DiscussionAssigneeResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class DiscussionResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'topic' => $this->resource->topic,
            'description' => $this->resource->description,
            'closestatus' => $this->resource->closestatus,
            'archivestatus' => $this->resource->archivestatus,
            'created_at' => $this->resource->created_at,
            'user_id' => $this->resource->user_id,
            'author' =>  new UserResource($this->resource->author),
            'dassignees' => $this->resource->dassignees,
            'assignees' => DiscussionAssigneeResource::collection($this->resource->assignees ?? collect())->format('short'),
            'chats' => ChatResource::collection($this->resource->chats ?? collect())->format('short'),
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
