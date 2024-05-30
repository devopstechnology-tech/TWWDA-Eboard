<?php

namespace App\Repository;

use App\Enums\RSVPEnum;
use App\Enums\AttendanceEnum;
use App\Repository\BaseRepository;
use App\Models\Module\Member\Attendance;
use App\Models\Module\Member\Membership;
use App\Http\Resources\AttendanceResource;
use App\Repository\Contracts\AttendanceInterface;

class AttendanceRepository extends BaseRepository implements AttendanceInterface
{
    // Implement the methods
    public function relationships()
    {
        return [
            'membership.user.profile',
            'membership.member',
            'meeting',
        ];
    }
    public function getAll()
    {
        // membership
        // meeting
        $filters = [
            // 'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Attendance::class, AttendanceResource::class, $filters);
    }
    public function getMeetingAttendances($meeting)
    {
        // $filters = [
        //     'meeting_id' => $meeting,
        //     'with' => $this->relationships(),
        //     'orderBy' => ['field' => 'id', 'direction' => 'asc']
        // ];
        // return $this->indexResource(Task::class, TaskResource::class, $filters);
        // dd(Attendance::get());
        $filters = [
            'meeting_id' => $meeting,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Attendance::class, AttendanceResource::class, $filters);
    }
    public function create(Membership | string $membership)
    {
        $attendance = new Attendance();
        $attendance->meeting_id        = $membership->meeting_id;
        $attendance->membership_id     = $membership->id;
        $attendance->rsvp_status       = RSVPEnum::Default->value;
        $attendance->attendance_status = AttendanceEnum::Default->value;
        $attendance->save();
        return $attendance;
    }
    public function update(Membership | string $membership)
    {
        $attendance = new Attendance();
        $attendance->meeting_id        = $membership->meeting_id;
        $attendance->membership_id     = $membership->id;
        $attendance->rsvp_status       = RSVPEnum::Default->value;
        $attendance->attendance_status = AttendanceEnum::Default->value;
        $attendance->save();
        return $attendance;
    }
    public function createRSVP(Attendance | string $attendance, array $payload)
    {
    }
    public function updateRSVP(Attendance | string $attendance, array $payload)
    {
        // dd($attendance);
        if (!($attendance instanceof Attendance)) {
            $attendance = Attendance::findOrFail($attendance);
        }
        $attendance->rsvp_status = $payload['rsvp_status'];
        $attendance->save();
        return $attendance;
    }
    public function SignAttendance(Attendance | string $attendance, array $payload)
    {
        if (!($attendance instanceof Attendance)) {
            $attendance = Attendance::findOrFail($attendance);
        }
        $attendance->attendance_status = $payload['attendance_status'];
        $attendance->save();
        return $attendance;
    }
    public function destroyAttendances(array $oldMembershipIds)
    {
        return Attendance::whereIn('membership_id', $oldMembershipIds)->forceDelete();
    }
    public function destroyMeetingAttendance(Attendance | string $attendance)
    {
    }
}
