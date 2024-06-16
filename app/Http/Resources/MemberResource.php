<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class MemberResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {

        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'board_id' => $this->resource->board_id,
            'board' => $this->resource->board,
            'committee_id' => $this->resource->committee_id,
            'committee' => $this->resource->committee,
            'guest_id' => $this->resource->guest_id,
            'guest' => $this->resource->guest,
            'position' => $this->resource->position,
            'position_id' => $this->resource->position_id,
            'user' => $this->resource->user,
            'updated_at' => $this->resource->updated_at,
            // 'profile' => (new ProfilResource($this->resource->user->profile))->format('short'),
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