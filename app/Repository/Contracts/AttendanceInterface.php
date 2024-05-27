<?php

namespace App\Repository\Contracts;

use App\Http\Resources\SettingResource;
use App\Models\Module\Member\Attendance;

interface AttendanceInterface
{
    // Define your methods here
    public function getAll();
    public function getMeetingAttendances($meeting);
    public function createAttendance($meeting, array $payload);
    public function updateAttendance(Attendance | string $attendance, array $payload);
    public function createRSVP(Attendance | string $attendance, array $payload);
    public function updateRSVP(Attendance | string $attendance, array $payload);
    public function SignAttendance(Attendance | string $attendance, array $payload);
    public function destroyMeetingAttendance(Attendance | string $attendances);
}