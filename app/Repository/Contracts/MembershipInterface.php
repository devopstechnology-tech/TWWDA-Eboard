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
    public function getMembershipAuth($model);
    public function getMeetingMemberships($schedule);
    public function notifyMeetingLeads($minute); //onminutes approval
    public function getAuthMembership(): Membership;
    public function updateMemberships(Meeting|string $meeting, Schedule|string $schedule, array $payload): Membership;
    public function updateMembershipPosition(Meeting|string $meeting, Schedule|string $schedule, array $payload): Membership;
    public function create($meeting, $member, $schedule, array $payload): void;
}