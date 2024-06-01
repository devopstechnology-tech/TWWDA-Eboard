<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;

interface MemberInterface
{
    // Define your methods here
    // Define your methods here
    public function getAll();
    public function getBoardMembers($member);
    public function updateMembers(Board|string $board, array $payload): Board;
    public function updateMemberRole(Board|string $board, array $payload): Board;
    // public function get(Member|string $member): Member;
    // public function boardMeeting(Member|string $member): Member;
    // public function committeeMeeting(Member|string $member): Member;
    // public function getBoardmeetings(Member|string $member): Member;
    // public function getCommitteeMeetings(Member|string $member): Member;

    // public function create(Member|string $member, array $payload): void;

    // public function update(Member|string $member, array $payload): Member;

    // public function delete(Member|string $member): bool;
}