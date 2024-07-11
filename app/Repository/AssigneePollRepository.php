<?php

namespace App\Repository;

use App\Models\Module\Poll\Poll;
use App\Models\Module\Board\Board;
use App\Repository\BaseRepository;
use App\Models\Module\Member\Member;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use App\Models\Module\Poll\AssigneePoll;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\PollInterface;
use App\Repository\Contracts\AssigneePollInterface;

class AssigneePollRepository extends BaseRepository implements AssigneePollInterface
{
    private $pollRepository;

    public function getPollRepository(): PollInterface
    {
        return $this->pollRepository ??= resolve(PollInterface::class);
    }

    public function create(Poll|string $poll, array $payload): AssigneePoll
    {
        $entityType = $payload['entity_type'];
        [$assignableIds, $assignableType, $columnType] = $this->getAssignableDetails($entityType, $poll);

        if ($payload['assigneetype'] === 'all_members') {
            AssigneePoll::where('poll_id', $poll->id)->forceDelete();
            return $this->createAllMembers($poll, $assignableIds, $assignableType, $payload);
        } else {
            foreach ($payload['pollassignees'] as $assignable) {
                $assigneePoll = new AssigneePoll();
                $assigneePoll->poll_id = $poll->id;
                $assigneePoll->assignable_id = $assignable[$columnType];
                $assigneePoll->assignable_type = $assignableType;
                $assigneePoll->save();
            }
        }
        return AssigneePoll::firstWhere('poll_id', $poll->id);
    }

    public function createAllMembers(Poll $poll, $assignableIds, $assignableType, array $payload)
    {
        foreach ($assignableIds as $assignableId) {
            $assigneePoll = new AssigneePoll();
            $assigneePoll->poll_id = $poll->id;
            $assigneePoll->assignable_id = $assignableId;
            $assigneePoll->assignable_type = $assignableType;
            $assigneePoll->save();
        }
        return AssigneePoll::firstWhere('poll_id', $poll->id);
    }

    public function update(Poll|string $poll, array $payload): AssigneePoll
{
    $entityType = $payload['entity_type'];
    [$assignableIds, $assignableType, $columnType] = $this->getAssignableDetails($entityType, $poll);
    AssigneePoll::where('poll_id', $poll->id)->forceDelete();
    if ($payload['assigneetype'] === 'all_members') {
        return $this->createAllMembers($poll, $assignableIds, $assignableType, $payload);
    } else {
        foreach ($payload['pollassignees'] as $potentialAssignee) { 
            // dd($columnType, $assignableType, $potentialAssignee);  
                    $assigneePoll = new AssigneePoll();
                    $assigneePoll->poll_id = $poll->id;
                    $assigneePoll->assignable_id = $potentialAssignee[$columnType];
                    $assigneePoll->assignable_type = $assignableType; // Ensure $assignableType is defined
                    $assigneePoll->save();
            }
            return AssigneePoll::firstWhere('poll_id', $poll->id); // Ensure a default object is returned if nothing found
        }

}

protected function getAssignableDetails($entityType, Poll|string $poll): array
{
    $assignableIds = [];
    $assignableType = null;
    $columnType = null;

    switch ($entityType) {
        case Board::class:
            $board = Board::with('members')->findOrFail($poll->board_id);
            $assignableIds = $board->members->pluck('id')->toArray();
            $assignableType = Member::class;
            $columnType = 'member_id';
            break;

        case Meeting::class:
            $meeting = Meeting::with('memberships')->findOrFail($poll->meeting_id);
            $assignableIds = $meeting->memberships->pluck('id')->toArray();
            $assignableType = Membership::class;
            $columnType = 'membership_id';
            break;

        case Committee::class:
            $committee = Committee::with('members')->findOrFail($poll->committee_id);
            $assignableIds = $committee->members->pluck('id')->toArray();
            $assignableType = Member::class;
            $columnType = 'member_id';
            break;

        default:
            throw new \Exception("Invalid entity type: {$entityType}");
    }

    return [$assignableIds, $assignableType, $columnType];
    }


}
