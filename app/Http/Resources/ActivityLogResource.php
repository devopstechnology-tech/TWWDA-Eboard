<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class ActivityLogResource extends BaseResource
{
    #[Format, IsDefault]
    public function default(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'approver' => $this->resource->approver,
            'reason' => $this->resource->reason,
        ];
    }
}
