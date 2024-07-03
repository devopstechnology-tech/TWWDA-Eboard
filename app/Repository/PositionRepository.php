<?php

namespace App\Repository;

use App\Enums\StatusEnum;
use App\Repository\BaseRepository;
use App\Models\Module\Member\Position;
use App\Http\Resources\PositionResource;
use App\Repository\Contracts\PositionInterface;

class PositionRepository extends BaseRepository implements PositionInterface
{
    // Implement the methods
    public function getBoardPositions()
    {
        $filters = [
            'model' => 'board',
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Position::class, PositionResource::class, $filters);
    }
    public function getCommitteePositions()
    {
        $filters = [
            'model' => 'committee',
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Position::class, PositionResource::class, $filters);
    }
    public function getMeetingPositions()
    {
        $filters = [
            'model' => 'meeting',
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Position::class, PositionResource::class, $filters);
    }
    public function storePosition(array $payload)
    {
        $position = new Position();
        $position->name = $payload['name'];
        $position->description = $payload['description'];
        $position->model = $payload['model'];
        $position->icon = $payload['icon'];
        $position->active = StatusEnum::Active->value;
        $position->save();
        return $position;
    }
    public function updatePosition($position, array $payload)
    {
        if (!($position instanceof Position)) {
            $position = Position::findOrFail($position);
        }
        $position->name = $payload['name'];
        $position->description = $payload['description'];
        $position->model = $payload['model'];
        $position->icon = $payload['icon'];
        $position->active = $payload['active'];
        $position->save();
        return $position;
    }
    public function activatePosition($position)
    {
        if (!($position instanceof Position)) {
            $position = Position::findOrFail($position);
        }
        $position->active = StatusEnum::Active->value;
        $position->save();
        return $position;
    }
    public function deactivatePosition($position)
    {
        if (!($position instanceof Position)) {
            $position = Position::findOrFail($position);
        }
        $position->active = StatusEnum::Inactive->value;
        $position->save();
        return $position;
    }
    public function destroyPosition($position)
    {
        if (!($position instanceof Position)) {
            $position = Position::findOrFail($position);
        }
        $position->delete();
        return $position;
    }
    public function ForcedestroyPosition($position)
    {
        if (!($position instanceof Position)) {
            $position = Position::findOrFail($position);
        }

        $position->forceDelete();
        return $position;
    }
}