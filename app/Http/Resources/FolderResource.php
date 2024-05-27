<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class FolderResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'folderable' => [
                'type' => class_basename($this->folderable_type),  // Extracts simple class name
                'details' => $this->folderable,
            ],
            'media' =>  MediaResource::collection($this->whenLoaded('media')),
            // 'subdetailminute' => (new SubDetailMinuteResource($this->resource->subdetailminute))->format('short'),
            'children' => $this->resource->children,
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
