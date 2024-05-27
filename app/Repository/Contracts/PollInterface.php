<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Poll\Poll;

interface PollInterface
{
    // Define your methods here
    public function getAll();
    public function getPoll(Poll |string $poll);
    public function getMeetingPolls($meeting);
    public function createMeetingPoll(Meeting|string $meeting, Board|string $board, array $payload): Poll;
    public function updateMeetingPoll(Meeting|string $meeting, $board, Poll $poll, array $payload): Poll;
}