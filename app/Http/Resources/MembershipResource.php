<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\PositionResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class MembershipResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'location' => $this->resource->location,
            'meeting_id' => $this->resource->meeting_id,
            'meeting' => $this->resource->meeting,
            'member_id' => $this->resource->member_id,
            'member' => $this->resource->member,
            'signature' => $this->resource->signature,
            'status' => $this->resource->status,
            'user_id' => $this->resource->user_id,
            'position_id' => $this->resource->position_id,
            'position' => new PositionResource($this->resource->position),
            'user' => $this->resource->user,
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