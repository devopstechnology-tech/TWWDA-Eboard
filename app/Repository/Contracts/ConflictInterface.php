<?php

namespace App\Repository\Contracts;

use App\Models\Module\Conflict\Conflict;
use App\Models\Module\Meeting\Meeting;

interface ConflictInterface
{
    // Define your methods here
    public function getAll();
    public function getMeetingConflicts($meeting);
    public function createMeetingConflict(Meeting|string $meeting, Array $payload): Conflict;
    public function updateMeetingConflict(Meeting|string $meeting, Conflict|string $conflict, Array $payload): Conflict;



}
