<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;

interface MembershipInterface
{
    // Define your methods here
    public function getMeetingBoardMemberships($meeting, $board);
    public function getAuthMembership(): Membership;
    public function updateMeetingBoardMemberships(Meeting|string $meeting, Board|string $board, array $payload): Membership;
    public function create($meeting, $member, array $payload): void;
}
