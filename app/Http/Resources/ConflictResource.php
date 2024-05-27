<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class ConflictResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'address'=>$this->resource->address,
            'nature'=>$this->resource->nature,
            'amount'=>$this->resource->amount,
            'ceased_date'=>$this->resource->ceased_date,
            'remarks'=>$this->resource->remarks,
            'meeting_id'=>$this->resource->meeting_id,
            'meeting'=>$this->resource->meeting,
            'membership_id'=>$this->resource->membership_id,
            'membership'=>$this->resource->membership,
            'signature'=>$this->resource->signature,
            'status'=>$this->resource->status,
            'media' =>  MediaResource::collection($this->whenLoaded('media')),
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
