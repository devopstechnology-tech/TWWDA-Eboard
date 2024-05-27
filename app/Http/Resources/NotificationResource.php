<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class NotificationResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {


        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'data' => $this->resource->data,
            'read_at' => $this->resource->read_at,
            'notifiable' => [
                'type' => class_basename($this->notifiable_type),  // Extracts simple class name
                'details' => $this->notifiable,
            ],
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