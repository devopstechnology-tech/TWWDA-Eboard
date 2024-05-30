<?php

namespace App\Repository\Contracts;

use App\Http\Resources\SettingResource;
use App\Models\Module\Member\Attendance;
use App\Models\Module\Member\Membership;

interface AttendanceInterface
{
    // Define your methods here
    public function getAll();
    public function getMeetingAttendances($meeting);
    public function create(Membership | string $membership);
    public function update(Membership | string $membership);
    public function createRSVP(Attendance | string $attendance, array $payload);
    public function updateRSVP(Attendance | string $attendance, array $payload);
    public function SignAttendance(Attendance | string $attendance, array $payload);
    public function destroyAttendances(array $oldMembershipIds);
    public function destroyMeetingAttendance(Attendance | string $attendances);
}