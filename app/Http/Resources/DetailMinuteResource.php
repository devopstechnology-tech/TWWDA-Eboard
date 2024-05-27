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
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'minute_id' => $this->resource->minute_id,
            'agenda_id' => $this->resource->agenda_id,
            // 'minute' => Minute::query()->find($this->$this->resource->minute_id),
            // 'agenda' => $this->whenLoaded('agenda', $this->resource->agenda, null),
            // 'subdetailminute' => SubDetailMinute::query()->where('detail_minute_id', $this->resource->getRouteKey())->first(),
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
            'id' => $this->resource->getRouteKey(),
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'minute_id' => $this->resource->minute_id,
            'agenda_id' => $this->resource->agenda_id,
            // 'subdetailminute' => SubDetailMinute::query()->where('detail_minute_id', $this->resource->getRouteKey())->first(),
            'subdetailminute' => (new SubDetailMinuteResource($this->resource->subdetailminute))->format('short'),
        ];
    }
}
