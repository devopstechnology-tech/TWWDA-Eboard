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
    public function getScheduleAttendances($schedule);
    public function create(Schedule | string $schedule, Membership | string $membership);
    public function update(Schedule | string $schedule, Membership | string $membership);
    public function createRSVP(Attendance | string $attendance, array $payload);
    public function updateRSVP(Attendance | string $attendance, array $payload);
    public function SignAttendance(Attendance | string $attendance, array $payload);
    public function destroyAttendances(array $oldMembershipIds);
    public function destroyScheduleAttendance(Attendance | string $attendances);
}
