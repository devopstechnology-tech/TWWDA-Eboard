<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Resources\MinuteResource;
use App\Models\Module\Meeting\Minute;
use App\Repository\Contracts\DetailMinuteInterface;
use App\Repository\Contracts\MembershipInterface;
use App\Repository\Contracts\MinuteInterface;
use Illuminate\Support\Facades\Auth;

class MinuteRepository extends BaseRepository implements MinuteInterface
{
    // Implement the methods
    public function __construct(
        private readonly DetailMinuteInterface $detailminuteRepository,
        private readonly MembershipInterface $membershipRepository
    ) {
    }
    public function relationships()
    {
        return [
                'detailminutes',
                'detailminutes.subdetailminute',
                'meeting',
                'board',
                'committee',
                'membership'
            ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical MinuteResource for transformation
        $filters = [
           'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
           ];
        return $this->indexResource(Minute::class, MinuteResource::class, $filters);
    }

    public function get(Minute|string $minute): Minute
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }

        return $minute;
    }

    public function getMeetingMinutes($meeting)
    {
        // Filters array with additional key for eager loading
        $filters = [
            'meeting_id' => $meeting,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
              // This 'with' key could be handled in indexResource for eager loading
        ];
        return $this->indexResource(Minute::class, MinuteResource::class, $filters);
    }

    // Implement the methods

    public function create($meeting, array $payload)
    {
        if (isset($payload['minute_id']) && !empty($payload['minute_id'])) {
            $minute = Minute::findOrFail($payload['minute_id']);
        } else {
            $minute = new Minute();
            $minute->meeting_id     = $meeting;
            $minute->board_id       = $payload['board_id'];
            $minute->committee_id   = $payload['committee_id'];
            $minute->membership_id  = $this->membershipRepository->getAuthMembership()->id;
            $minute->save();
        }

        if($minute) {
            $this->detailminuteRepository->create($minute, $payload);
        }
        return $minute;
    }

    public function update($minute, array $payload): Minute
    {
        $minute = Minute::findOrFail($payload['minute_id']);
        if($minute) {
            $this->detailminuteRepository->update($minute, $payload);
        }
        return $minute;
    }
    public function createsubminute($meeting, array $payload)
    {
        // dd($payload);

        $minute = Minute::findOrFail($payload['minute_id']);
        if($minute) {
            $this->detailminuteRepository->createSubMinute($minute, $payload);
        }
        return $minute;
    }
    public function updateSubMinute($subminute, array $payload)
    {
        $minute = Minute::findOrFail($payload['minute_id']);
        if($minute) {
            $this->detailminuteRepository->updateSubMinute($minute, $payload);
        }
        return $minute;
    }
    public function delete(Minute|string $minute): bool
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }

        return $minute->delete();
    }// Implement the methods


}
