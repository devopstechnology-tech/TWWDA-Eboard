<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Poll\Poll;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Committe\Committee;

interface PollInterface
{
    // Define your methods here
    public function getAll();
    public function getPoll(Poll |string $poll);
    // public function updatePoll(Meeting|string $meeting, array $payload): Poll;
    //meeting

    public function getMeetingPolls($meeting);
    public function createMeetingPoll(Meeting|string $meeting, array $payload): Poll;
    public function updateMeetingPoll(Meeting|string $meeting, Poll $poll, array $payload): Poll;

    //board
    public function getBoardPolls($board);
    public function createBoardPoll(Board $board, array $payload): Poll;
    public function updateBoardPoll(Poll $poll, array $payload): Poll;

    //committee
    public function getCommitteePolls($committee);
    public function createCommitteePoll(Committee $committee, array $payload): Poll;
    public function updateCommitteePoll(Poll $poll, array $payload): Poll;
}