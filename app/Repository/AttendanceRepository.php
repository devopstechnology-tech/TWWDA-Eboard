<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use App\Http\Resources\AttendanceResource;
use App\Models\Module\Member\Attendance;
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
    public function createAttendance($meeting, array $payload)
    {
    }
    public function updateAttendance(Attendance | string $attendance, array $payload)
    {
        // if (!($attendance instanceof Attendance)) {
        //     $attendance = Attendance::findOrFail($attendance);
        // }
        // $attendance->rsvp_status = $payload['rsvp_status'];
        // $attendance->save();
        // return $attendance;
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
    public function destroyMeetingAttendance(Attendance | string $attendance)
    {
    }
}
