<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\DiscussionResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class ChatResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'discussion_id' => $this->resource->discussion_id,
            'discussion' => new DiscussionResource($this->resource->discussion),
            'assignee_sender_id' => $this->resource->assignee_sender_id,
            'assignee_receiver_id' => $this->resource->assignee_receiver_id,
            'message' => $this->resource->message,
            'editstatus' => $this->resource->editstatus,
            'file' => $this->resource->file,
            'media' =>  MediaResource::collection($this->whenLoaded('media')),
            'discussion' => $this->resource->discussion,
            'sender' => new UserResource($this->resource->sender),
            'receiver' => new UserResource($this->resource->receiver),
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