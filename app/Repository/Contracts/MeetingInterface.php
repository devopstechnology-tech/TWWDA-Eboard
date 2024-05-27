<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Meeting;

interface MeetingInterface
{
    public function getAll();

    public function getBoardMeetings($meeting);
    public function getCommitteeMeetings($meeting);
    public function get(Meeting|string $meeting): Meeting;
    public function getboardMeeting($meeting);
    public function getcommitteeMeeting($meeting);
    public function publishMeeting($meeting);

    public function create(array $payload): Meeting;

    public function update(Meeting|string $meeting, array $payload): Meeting;
    public function updateMembers(Meeting|string $meeting, array $payload): Meeting;

    public function delete(Meeting|string $meeting): bool;
}
