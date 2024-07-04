<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Minute;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Position;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Membership;
use App\Http\Resources\MembershipResource;
use App\Repository\Contracts\AttendanceInterface;
use App\Repository\Contracts\MembershipInterface;
use App\Notifications\MeetingNewMembershipNotification;
use App\Notifications\MinuteApprovalRequestNotification;

class MembershipRepository extends BaseRepository implements MembershipInterface
{
    // Implement the methods
    public function __construct(
        private readonly AttendanceInterface $attendanceRepository,
    ) {
    }

    public function relationships()
    {
        return [
            'meeting',
            'position',
            'member',
            'user',
        ];
    }
    public function getMeetingMemberships($meeting, $board)
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
    public function create($meeting, $member, $schedule, array $payload): void
    {
        $defaultPositionId = Position::where('name', 'Meeting Member')
            ->where('model', 'meeting')
            ->first()->id;
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
        $membership->position_id = $defaultPositionId;
        $membership->save();

        if ($membership->save()) {
            $this->attendanceRepository->create($schedule, $membership);
        }
    }

    public function updateMemberships(Meeting|string $meeting, Schedule|string $schedule, array $payload): Membership
    {
        $defaultPositionId = Position::where('name', 'Meeting Member')
            ->where('model', 'meeting')
            ->first()->id;

        $memberIds = $payload['memberships'] ?? [];
        if (!($meeting instanceof Meeting)) {
            $meeting = Meeting::findOrFail($meeting);
        }

        $existingMembershipIds = $meeting->memberships->pluck('id')->toArray();
        foreach ($existingMembershipIds as $membershipId) {
            $membership = Membership::find($membershipId);
            $this->attendanceRepository->destroyAttendance($membership->id);
            $membership->forceDelete();
        }
        // Add new members or update existing ones
        foreach ($memberIds as $memberId) {
            $member = Member::findOrFail($memberId);
            if ($member) {
                $membership = new Membership();
                $membership->meeting_id        = $meeting->id;
                $membership->member_id         = $member->id;
                $membership->user_id           = $member->user_id;
                $membership->position_id       = $defaultPositionId;
                $membership->memberable_id     = $meeting->id;
                $membership->memberable_type   = Meeting::class;
                $membership->save();

                if ($membership) {
                    $this->attendanceRepository->update($schedule, $membership);
                }
            }
        }
        $membership = Membership::where('meeting_id', $meeting->id)->first();
        return $membership;
    }
    public function updateMembershipPosition(Meeting|string $meeting, Schedule|string $schedule, array $payload): Membership
    {

        $membership = Membership::findOrFail($payload['id']);
        $membership->position_id =  $payload['position_id'];
        $membership->save();

        return $membership;
    }
    public function notifyMeetingLeads($minute)
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::with('schedule')->findOrFail($minute);
        }
        // Fetch the schedule associated with the minute
        $schedule = $minute->schedule;
        // // Access the meeting associated with the schedule
        $meeting = $schedule->meeting;
        $board = $meeting->meetingable_id;
        // dd($board);
        // Get the meeting title and schedule date
        $meetingTitle = $meeting->title;
        $scheduleDate = $schedule->date;
        $Chairperson = Position::where('name', 'Meeting Chairperson')->first()->id;
        // $ViceChairperson = Position::where('name', 'Vice-Chairperson')->first()->id;

        $membershipUserIds = Membership::whereIn('position_id', [$Chairperson])->pluck('user_id')->toArray();

        $users = User::whereIn('id', $membershipUserIds)->get();
        $updateMessage = "The minutes for the meeting titled '{$meetingTitle}', held on '{$scheduleDate}', have been established.";
        foreach ($users as $user) {
            $user->notify(new MinuteApprovalRequestNotification($user, $minute, $updateMessage));
        }
    }
}