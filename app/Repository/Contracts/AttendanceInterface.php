<?php

namespace App\Repository\Contracts;

use App\Http\Resources\SettingResource;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Attendance;
use App\Models\Module\Member\Membership;

interface AttendanceInterface
{
    // Define your methods here
    public function getAll();
    public function getSignatureFile($attendance, $file);
    public function updateSignatureFile(Attendance | string $attendance, $file, array $payload);
    public function getScheduleAttendances($schedule);
    public function create(Schedule | string $schedule, Membership | string $membership);
    public function update(Schedule | string $schedule, Membership | string $membership);
    public function Reminder(Attendance | string $attendance);
    public function createRSVP(Attendance | string $attendance, array $payload);
    public function updateRSVP(Attendance | string $attendance, array $payload);
    // public function SignAttendance(Attendance | string $attendance, array $payload);
    public function destroyAttendance($oldMembershipId);
    public function destroyAttendances(array $oldMembershipIds);
    public function destroyScheduleAttendance(Attendance | string $attendances);
}
