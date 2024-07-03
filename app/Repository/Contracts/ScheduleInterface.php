<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Member\Member;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Meeting\Schedule;

interface ScheduleInterface
{
    public function getAll();
    public function get(Schedule|string $schedule): Schedule;
    public function createSchedule(Meeting|string $meeting, Member|string $member, array $payload): void;
    public function updateSchedule(Meeting|string $meeting, array $payload): void;
    public function updateMembers(Schedule|string $schedule, array $payload): void;
    public function update(Schedule|string $schedule, array $payload): Schedule;
    public function delete(Schedule|string $schedule): bool;

    public function closeSchedule(Schedule|string $schedule);
}
