<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\MeetingResource;
use App\Http\Resources\DetailMinuteResource;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class MinuteResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        if (!$this->resource) {
            return []; // or return a default array structure
        }

        return [
            'id' => $this->resource->getRouteKey(),
            'schedule_id' => $this->resource->schedule_id,
            'schedule' => $this->resource->schedule,
            'meeting' => $this->resource->schedule ? (new MeetingResource($this->resource->schedule->meeting))->format('short') : null,
            'membership_id' => $this->resource->membership_id,
            'status' => $this->resource->status,
            'author' => $this->resource->author,
            'detailminutes' => DetailMinuteResource::collection($this->resource->detailminutes ?? collect())->format('short'),
            'minuteReviews' => MinuteReviewResource::collection($this->resource->minuteReviews ?? collect())->format('short'),
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        if (!$this->resource) {
            return []; // or return a default array structure
        }

        return [
            // Short resource fields here
        ];
    }
}