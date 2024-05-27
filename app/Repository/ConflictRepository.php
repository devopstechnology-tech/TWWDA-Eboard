<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use App\Models\Module\Meeting\Meeting;
use App\Http\Resources\ConflictResource;
use App\Models\Module\Conflict\Conflict;
use App\Repository\Contracts\ConflictInterface;
use App\Repository\Contracts\MembershipInterface;

class ConflictRepository extends BaseRepository implements ConflictInterface
{
    public function __construct(
        private readonly MembershipInterface $membershipRepository,
    ) {
    }
    // Implement the methods
    public function relationships()
    {
        return [
                 'media',
                 'meeting',
                 'membership.user',
            ];
    }
    public function getAll()
    {
        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Conflict::class, ConflictResource::class, $filters);
    }
public function getMeetingConflicts($meeting)
    {
        $filters = [
            'meeting_id'   => $meeting,
            'with'         => $this->relationships(),
            'orderBy'      => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Conflict::class, ConflictResource::class, $filters);
    }
    public function createMeetingConflict(Meeting|string $meeting, array $payload): Conflict
    {
        $conflict = new Conflict();
         $conflict->address = $payload['address'];
         $conflict->nature = $payload['nature'];
         $conflict->amount = $payload['amount'];
         $conflict->ceased_date = $payload['ceased_date'];
         $conflict->remarks = $payload['remarks'];
         $conflict->meeting_id = $meeting->id;
         $conflict->membership_id = $this->membershipRepository->getAuthMembership()->id;
        //  $conflict->signature = $payload['signature'];//null if savwde is media file signuture
        //  $conflict->status = $payload['status'];//default not signed
        $conflict->save();
        return $conflict;
    }
 public function updateMeetingConflict(Meeting|string $meeting, Conflict|string $Conflict, array $payload): Conflict
    {
        $conflict = Conflict::find($payload['conflict_id']);
        $conflict->address = $payload['address'];
         $conflict->nature = $payload['nature'];
         $conflict->amount = $payload['amount'];
         $conflict->ceased_date = $payload['ceased_date'];
         $conflict->remarks = $payload['remarks'];
         $conflict->meeting_id = $meeting->id;
        //  $conflict->membership_id = $this->membershipRepository->getAuthMembership()->id;
        //  $conflict->signature = $payload['signature'];//null if savwde is media file signuture
        //  $conflict->status = $payload['status'];//default not signed
        $conflict->save();

        return $conflict;
    }

}
