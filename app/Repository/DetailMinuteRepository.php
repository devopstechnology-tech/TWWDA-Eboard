<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Module\Meeting\Minute;
use App\Models\Module\Meeting\Minute\DetailMinute;
use App\Models\Module\Meeting\Minute\SubDetailMinute;
use App\Repository\Contracts\DetailMinuteInterface;

class DetailMinuteRepository extends BaseRepository implements DetailMinuteInterface
{
    // Implement the methods
    public function create(Minute|string $minute, array $payload): void
    {
        DetailMinute::create([
                'minute_id'    => $minute->id,
                'agenda_id'    => $payload['agenda_id'],
                'description'  => $payload['description'],
                'status'       => $payload['status'],
            ]);
    }
    public function update(Minute|string $minute, array $payload): void
    {
        $detailminute = DetailMinute::findOrFail($payload['detail_minute_id']);
        $detailminute->minute_id   = $minute->id;
        $detailminute->agenda_id   = $payload['agenda_id'];
        $detailminute->description = $payload['description'];
        $detailminute->status      = $payload['status'];
        $detailminute->save();
    }
    public function getDetailMinute(Minute|string $minute, array $payload)
    {
        return DetailMinute::where('agenda_id', $payload['agenda_id'])
                             ->where('minute_id', $minute->id)->first();
    }
    public function createSubMinute(Minute|string $minute, array $payload): void
    {
        // dd($payload);
        // dd($this->getDetailMinute($minute, $payload));
        SubDetailMinute::create([
        'detail_minute_id' => $this->getDetailMinute($minute, $payload)->id,
        'subagenda_id' => $payload['subagenda_id'],
        'description' => $payload['description'],
        'status' => $payload['status'],
    ]);

    }
    public function updateSubMinute(Minute|string $minute, array $payload): void
    {
        $subdetailminute = SubDetailMinute::findOrFail($payload['subdetailminute_id']);
        $subdetailminute->detail_minute_id = $payload['detail_minute_id'];
        $subdetailminute->subagenda_id  = $payload['subagenda_id'];
        $subdetailminute->description  = $payload['description'];
        $subdetailminute->status  = $payload['status'];
        $subdetailminute->save();
    }
}
