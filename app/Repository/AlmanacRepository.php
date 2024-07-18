<?php

namespace App\Repository;

use App\Enums\HeldEnum;
use App\Enums\ApprovalEnum;
use App\Models\System\Almanac;
use App\Imports\AlmanacsImport;
use App\Repository\BaseRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\AlmanacResource;
use App\Repository\Contracts\AlmanacInterface;

class AlmanacRepository extends BaseRepository implements AlmanacInterface
{
    public function getAll()
    {
        $filters = [
            // 'with' => $this->relationships(),
            'whereNot' => ['type' => 'sample'],
            'orderBy' => ['field' => 'start', 'direction' => 'asc'],
            // 'includeDeleted' => ''
        ];
        return $this->indexResource(Almanac::class, AlmanacResource::class, $filters);
    }
    public function getLatest()
    {
        $orderBy = ['field' => 'created_at', 'direction' => 'asc'];
        // Fetch the data
        $totalCount = Almanac::count();
        $almanacs = Almanac::orderBy($orderBy['field'], $orderBy['direction'])
            ->limit(5)
            ->get();

            $data =  [
                'count' => $totalCount,
                'almanacs' => $almanacs,
            ];
            return $data;
    }



    public function importAlmanac(array $payload)
    {
        $file = $payload['fileupload'];
        Excel::import(new AlmanacsImport($payload), $file);
        return Almanac::first();
    }
    public function createAlmanac(array $payload): Almanac
    {
        $almanac = new Almanac();
        $almanac->type          = $payload['type'];
        $almanac->purpose       = $payload['purpose'];
        $almanac->start         = $payload['start'];
        $almanac->end           = $payload['end'];
        $almanac->budget        = $payload['budget'];
        $almanac->status        = ApprovalEnum::Default->value;
        $almanac->held          = HeldEnum::Default->value;
        $almanac->save();
        return $almanac;
    }
    public function updateAlmanac(Almanac|string $almanac, array $payload): Almanac
    {
        if (!($almanac instanceof Almanac)) {
            $almanac = Almanac::findOrFail($almanac);
        }
        $almanac->type          = $payload['type'];
        $almanac->purpose       = $payload['purpose'];
        $almanac->start         = $payload['start'];
        $almanac->end           = $payload['end'];
        $almanac->budget        = $payload['budget'];
        $almanac->status        = $payload['status'];
        $almanac->held    = $payload['held'];
        $almanac->save();
        return $almanac;
    }
    public function approveAlmanac(Almanac|string $almanac): Almanac
    {
        if (!($almanac instanceof Almanac)) {
            $almanac = Almanac::findOrFail($almanac);
        }
        $almanac->status   = ApprovalEnum::Approved->value;
        $almanac->save();
        return $almanac;
    }
    public function markHeldAlmanac(Almanac|string $almanac): Almanac
    {
        if (!($almanac instanceof Almanac)) {
            $almanac = Almanac::findOrFail($almanac);
        }
        $almanac->held   = HeldEnum::Held->value;
        $almanac->save();
        return $almanac;
    }
    public function markCancelledAlmanac(Almanac|string $almanac): Almanac
    {
        if (!($almanac instanceof Almanac)) {
            $almanac = Almanac::findOrFail($almanac);
        }
        $almanac->held   = HeldEnum::Cancelled->value;
        $almanac->save();
        return $almanac;
    }
    public function markPostponedAlmanac(Almanac|string $almanac): Almanac
    {
        if (!($almanac instanceof Almanac)) {
            $almanac = Almanac::findOrFail($almanac);
        }
        $almanac->held   = HeldEnum::Postponed->value;
        $almanac->save();
        return $almanac;
    }
    public function deleteAlmanac(Almanac|string $almanac): Almanac
    {
        if (!($almanac instanceof Almanac)) {
            $almanac = Almanac::findOrFail($almanac);
        }
        $almanac->delete();
        return $almanac;
    }


    // purpose
    // day
    // duration
    // budget
    // status
}
