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
            'user_id' => $this->resource->user_id,
            'author' =>  new UserResource($this->resource->author),
            'assignees' => DiscussionAssigneeResource::collection($this->resource->assignees ?? collect()),
            'chats' => ChatResource::collection($this->resource->chats ?? collect()),
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
