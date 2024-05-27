<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Resources\ModificationResource;
use App\Models\System\Modification;
use App\Repository\Contracts\v1\ModificationInterface;

class ModificationRepository extends BaseRepository implements ModificationInterface
{
    public function getAll()
    {
        return $this->indexResource(Modification::class, ModificationResource::class);
    }

    public function delete(Modification|string $modification): bool
    {
        if (!($modification instanceof Modification)) {
            $modification = Modification::findOrFail($modification);
        }

        return $modification->delete();
    }

    public function create(array $payload): ModificationResource
    {
        $account = Modification::firstOrCreate($payload);

        return ModificationResource::make($account);
    }

    public function get(Modification|string $modification): ModificationResource
    {
        if (!($modification instanceof Modification)) {
            $modification = Modification::findOrFail($modification);
        }

        return ModificationResource::make($modification);
    }

    public function update(Modification|string $modification, array $payload): ModificationResource
    {
        if (!($modification instanceof Modification)) {
            $modification = Modification::findOrFail($modification);
        }
        $modification->update($payload);
        $modification->save();

        return ModificationResource::make($modification);
    }

    public function disapprove(Modification|string $modification, string $reason): bool
    {
        if (!($modification instanceof Modification)) {
            $modification = Modification::findOrFail($modification);
        }
        $modification->load('modifiable', 'modifier');

        return request()->user()->disapprove($modification, $reason);
    }

    public function approve(Modification|string $modification, string $reason): bool
    {
        if (!($modification instanceof Modification)) {
            $modification = Modification::findOrFail($modification);
        }
        $modification->load('modifiable', 'modifier');

        return request()->user()->approve($modification, $reason);
    }
}
