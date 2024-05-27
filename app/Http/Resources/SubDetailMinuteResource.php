<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class SubDetailMinuteResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'detail_minute_id' => $this->resource->detail_minute_id,
            'subagenda_id' => $this->resource->subagenda_id,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'detail_minute_id' => $this->resource->detail_minute_id,
            'subagenda_id' => $this->resource->subagenda_id,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
        ];
    }
}
