<?php

namespace App\Repository;

use App\Models\Module\Poll\Poll;
use App\Repository\BaseRepository;
use App\Models\Module\Poll\AssigneePoll;
use App\Repository\Contracts\PollInterface;
use App\Repository\Contracts\AssigneePollInterface;

class AssigneePollRepository extends BaseRepository implements AssigneePollInterface
{
    private $pollRepository;

    public function getPollRepository(): PollInterface
    {
        // Lazily load the AssigneePollRepository when needed
        return $this->pollRepository ??= resolve(PollInterface::class);
    }

    // Implement the methods
    public function create(Poll|string $poll, array $payload): AssigneePoll
    {
        if ($payload['assigneetype'] === 'all_members') {
            return $this->createAllMembers($poll, $payload);
        } else {
            $memberships = $payload['pollassignees'];
            foreach ($memberships as $membership) {
                $assigneepoll                = new AssigneePoll();
                $assigneepoll->poll_id       = $poll->id;
                $assigneepoll->membership_id = $membership['id'];
                $assigneepoll->save();
            }
        }
        return AssigneePoll::firstWhere('poll_id', $poll->id);
    }

    public function createAllMembers(Poll|string $poll, array $payload)
    {
        // $existingAssignees = AssigneePoll::where('poll_id', $poll->id)->forceDelete();
        $existingAssignees = AssigneePoll::where('poll_id', $poll->id)
            ->get()->each->forceDelete();
        $singlepoll = $this->getPollRepository()->getPoll($poll);
        $meeting = $singlepoll->meeting;
        if ($meeting) {
            $memberships = $meeting->memberships()->get();
            $membershipsMap = $memberships->keyBy('id')->toArray();
            foreach ($membershipsMap as $membershipsmap) {
                // dd($membershipsmap);
                // Optionally delete or deactivate unused assignees
                $assigneepoll = new AssigneePoll();
                $assigneepoll->poll_id = $poll->id;
                $assigneepoll->membership_id = $membershipsmap['id'];
                $assigneepoll->save();
            }
        }
        return AssigneePoll::firstWhere('poll_id', $poll->id);
    }

    public function update(Poll|string $poll, array $payload): AssigneePoll
    {
        if ($payload['assigneetype'] === 'all_members') {
            // dd('we here '/);
            return $this->createAllMembers($poll, $payload);
        } else {
            $existingAssignees = AssigneePoll::where('poll_id', $poll->id)->get();
            $existingAssigneesMap = $existingAssignees->keyBy('membership_id')->toArray();
            // Process each assignee data from the payload
            foreach ($payload['pollassignees'] as $potentialAssignee) {
                // dd($potentialAssignee['membership_id'], isset($existingAssigneesMap[$potentialAssignee['membership_id']]));
                if (isset($existingAssigneesMap[$potentialAssignee['membership_id']])) {
                    // If the membership ID exists, update other details if needed
                    // For example, update something or just touch it to update timestamps
                    $assigneepoll = AssigneePoll::where('poll_id', $poll->id)
                        ->where('membership_id', $potentialAssignee['membership_id'])
                        ->first();
                    $assigneepoll->touch();
                    // Remove from the existing list to track which are still in use
                    unset($existingAssigneesMap[$potentialAssignee['membership_id']]);
                } else {
                    // If the membership ID does not exist, create a new assignee
                    $assigneepoll = new AssigneePoll();
                    $assigneepoll->poll_id = $poll->id;
                    $assigneepoll->membership_id = $potentialAssignee['membership_id'];
                    $assigneepoll->save();
                }
            }
            // Any remaining items in $existingAssigneesMap are not in the new payload and should be considered for deletion
            $deleteunusedMembershipId = $this->deleteonForce($poll, $existingAssigneesMap);
            return AssigneePoll::firstWhere('poll_id', $poll->id);
        }
    }
    public function deleteonForce(Poll|string $poll, $existingAssigneesMap)
    {
        foreach ($existingAssigneesMap as $unusedMembershipId => $unusedAssignee) {
            // Optionally delete or deactivate unused assignees
            AssigneePoll::where('poll_id', $poll->id)
                ->where('membership_id', $unusedMembershipId)
                ->forceDelete();  // Or another action as needed
        }
    }
}
