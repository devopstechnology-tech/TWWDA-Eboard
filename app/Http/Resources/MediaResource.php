<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class MediaResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'uuid' => $this->uuid,
            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'conversions_disk' => $this->conversions_disk,
            'size' => $this->size,
            'manipulations' => $this->manipulations,
            'custom_properties' => $this->custom_properties,
            'generated_conversions' => $this->generated_conversions,
            'responsive_images' => $this->responsive_images,
            'order_column' => $this->order_column,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
            'deleted_at' => $this->deleted_at ? $this->deleted_at->toIso8601String() : null,
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
