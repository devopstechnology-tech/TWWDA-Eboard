<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class MinuteResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        // if (!$this->resource->relationLoaded('meeting')) {
        //     $this->resource->load('meeting');
        // }
        // if (!$this->resource->relationLoaded('board')) {
        //     $this->resource->load('board');//fecthing only user id
        // }
        // if (!$this->resource->relationLoaded('committee')) {
        //     $this->resource->load('committee');//fecthing only user id
        // }
        // if (!$this->resource->relationLoaded('membership')) {
        //     $this->resource->load('membership');//fecthing only user id
        // }
        // if (!$this->resource->relationLoaded('detailminutes')) {
        //     $this->resource->load('detailminutes.subagendas');//fecthing only user id
        // }

        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'meeting_id' => $this->resource->meeting_id,
            'board_id' => $this->resource->board_id,
            'committee_id' => $this->resource->committee_id,
            'membership_id' => $this->resource->membership_id,
            'status' => $this->resource->status,
            //
            // 'meeting' =>$this->resource->meeting,
            // 'board' =>$this->resource->board,
            // 'committee' =>$this->resource->committee,
            // 'membership' =>$this->resource->membership,
            'detailminutes' => DetailMinuteResource::collection($this->resource->detailminutes)->format('short'),
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
