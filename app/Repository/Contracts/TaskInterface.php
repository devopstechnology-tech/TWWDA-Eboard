<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Task\Task;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;

interface TaskInterface
{
    // Define your methods here
    public function getAll();
    public function getTask(Task |string $poll);
    public function getMeetingTasks($meeting);
    public function createMeetingTask(Meeting|string $meeting, Board|string $board, array $payload): Task;
    public function updateMeetingTask(Meeting|string $meeting, $board, Task $task, array $payload): Task;
    public function updateTask(Meeting|string $meeting, array $payload): Task;
}
