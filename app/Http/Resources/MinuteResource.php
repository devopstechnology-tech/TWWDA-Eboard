<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\MeetingResource;
use App\Http\Resources\AttendanceResource;
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
            'attendances' => AttendanceResource::collection($this->resource->schedule->attendances ?? collect()),
            'meeting' => $this->resource->schedule ? (new MeetingResource($this->resource->schedule->meeting))->format('short') : null,
            'membership_id' => $this->resource->membership_id,
            'approvalstatus' => $this->resource->approvalstatus,
            'status' => $this->resource->status,
            'signatures' => $this->resource->signatures,
            'author' => $this->resource->author,
            'detailminutes' => DetailMinuteResource::collection($this->resource->detailminutes ?? collect())->format('short'),
            'minuteReviews' => MinuteReviewResource::collection($this->resource->minuteReviews ?? collect())->format('short'),
        ];
        // Access relationships only if they are loaded
        // return [
        //     'id' => $this->resource->getRouteKey(),
        //     'schedule_id' => $this->resource->schedule_id,
        //     'schedule' => $this->whenLoaded('schedule'),
        //     // 'attendances' => AttendanceResource::collection($this->whenLoaded('schedule') ? $this->resource->schedule->attendances : collect()),
        //     'meeting' => $this->whenLoaded('schedule') ? (new MeetingResource($this->resource->schedule->meeting))->format('short') : null,
        //     'membership_id' => $this->resource->membership_id,
        //     'approvalstatus' => $this->resource->approvalstatus,
        //     'status' => $this->resource->status,
        //     'signatures' => $this->resource->signatures,
        //     'author' => $this->whenLoaded('author'),
        //     'detailminutes' => DetailMinuteResource::collection($this->whenLoaded('detailminutes') ? $this->resource->detailminutes : collect())->format('short'),
        //     'minuteReviews' => MinuteReviewResource::collection($this->whenLoaded('minuteReviews') ? $this->resource->minuteReviews : collect())->format('short'),
        // ];
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