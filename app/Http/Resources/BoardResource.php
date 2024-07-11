<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class BoardResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'owner_id' => $this->resource->owner_id,
            'owner' => $this->owner->full_name,
            'icon' => $this->resource->icon,
            'cover' => $this->resource->cover,
            'members' => $this->resource->members,
            'folders' => $this->resource->folders,
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'owner_id' => $this->resource->owner_id,
            'icon' => $this->resource->icon,
            'cover' => $this->resource->cover,
        ];
    }
}
