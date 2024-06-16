<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Membership;

interface MembershipInterface
{
    // Define your methods here
    public function getMeetingBoardMemberships($schedule, $board);
    public function getAuthMembership(): Membership;
    public function updateMeetingBoardMemberships(Meeting|string $meeting, Schedule|string $schedule, array $payload): Membership;
    public function create($meeting, $member, $schedule, array $payload): void;
}