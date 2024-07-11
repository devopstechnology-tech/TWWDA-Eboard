<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Task\Task;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Committe\Committee;

interface TaskInterface
{
    // Define your methods here
    public function getAll();
    public function getTask(Task |string $poll);
    public function updateTask(Meeting|string $meeting, array $payload): Task;
    //meeting

    public function getMeetingTasks($meeting);
    public function createMeetingTask(Meeting|string $meeting, array $payload): Task;
    public function updateMeetingTask(Meeting|string $meeting, Task $task, array $payload): Task;

    //board
    public function getBoardTasks($board);
    public function createBoardTask(Board $board, array $payload): Task;
    public function updateBoardTask(Task $task, array $payload): Task;


    //committee
    public function getCommitteeTasks($committee);
    public function createCommitteeTask(Committee $committee, array $payload): Task;
    public function updateCommitteeTask(Task $task, array $payload): Task;



}
