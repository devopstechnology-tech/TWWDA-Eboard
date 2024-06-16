<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class PositionResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'active' => $this->resource->active,
            'created_at' => $this->resource->created_at,
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