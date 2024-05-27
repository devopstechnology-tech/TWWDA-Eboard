<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class PermissionResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'full_name' => $this->resource->full_name,
            'class' => $this->resource->class,
            'action' => $this->resource->action,
            'type' => $this->resource->type,
        ];
    }
}
