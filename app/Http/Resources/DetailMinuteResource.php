<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Minute;
use App\Models\Module\Meeting\Minute\SubDetailMinute;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class DetailMinuteResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'minute_id' => $this->resource->minute_id,
            'agenda_id' => $this->resource->agenda_id,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'minute' => $this->resource->minute,
            'agenda' => $this->resource->agenda,
            'subagenda' => $this->resource->subagenda,
            'subdetailminutes' =>  SubDetailMinuteResource::collection($this->resource->subdetailminutes ?? collect())->format('short'),
            'minutereview' => $this->resource->minutereview,
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'minute_id' => $this->resource->minute_id,
            'agenda_id' => $this->resource->agenda_id,
            'subdetailminutes' =>  SubDetailMinuteResource::collection($this->resource->subdetailminutes ?? collect())->format('short'),
        ];
    }
}
