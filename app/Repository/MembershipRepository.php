<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use App\Http\Resources\MembershipResource;
use App\Repository\Contracts\MembershipInterface;
use App\Notifications\MeetingNewMembershipNotification;

class MembershipRepository extends BaseRepository implements MembershipInterface
{
    // Implement the methods

    public function relationships()
    {
        return [
            'meeting',
            'member',
            'user',
        ];
    }
    public function getMeetingBoardMemberships($meeting, $board)
    {
        $filters = [
            'meeting_id' => $meeting,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        // $filters = ['board_id' => $board];
        return $this->indexResource(Membership::class, MembershipResource::class, $filters);
    }
    public function getAuthMembership(): Membership //get loggeid minute writer must be in mbershsip
    {
        return Membership::where('user_id', Auth::user()->id)->first();
    }
    public function updateMeetingBoardMemberships(Meeting|string $meeting, Board|string $board, array $payload): Membership
    {
        $membershipIds = $payload['memberships'] ?? [];

        // Retrieve the meeting object from the database
        $meetingObject = Meeting::findOrFail($meeting);

        // Retrieve old memberships        
        $oldMemberships = Membership::where('meeting_id', $meeting)
            ->where('user_id', '!=', $meetingObject->owner_id)
            ->get();

        // Optionally, if deleting is necessary
        $oldMemberships->each->delete();

        foreach ($membershipIds as $memberId) {
            $member = Member::findOrFail($memberId);

            // Skip the iteration if $member->user_id is equal to $meetingObject->owner_id
            if ($member->user_id == $meetingObject->owner_id) {
                continue;
            }

            $newMembership = Membership::create([
                'meeting_id' => $meeting,
                'member_id' => $member->id,
                'user_id' => $member->user_id,
                'memberable_id' => $meeting,
                'memberable_type' => Meeting::class,
            ]);
        }


        $membership = Membership::where('meeting_id', $meeting)->first();
        return $membership;
    }
    public function create($meeting, $member, array $payload): void
    {
        //memberable_id
        //memberable_type
        //meeting_id
        //member_id
        //user_id
        //location
        //signature
        //status
        $membership = new Membership();
        $membership->memberable_id = $meeting->id;
        $membership->memberable_type = Meeting::class;
        $membership->meeting_id = $meeting->id;
        $membership->member_id = $member->id;
        $membership->user_id = $member->user_id;
        $membership->save();
    }
}