<?php

namespace App\Repository;

use Carbon\Carbon;
use App\Enums\TaskEnum;
use App\Enums\VoteEnum;
use App\Models\Module\Task\Task;
use App\Repository\BaseRepository;
use App\Models\Module\Task\Sub\Taskstatus;
use App\Repository\Contracts\TaskstatusInterface;

class TaskstatusRepository extends BaseRepository implements TaskstatusInterface
{
    // Implement the methods
    public function tasking(Task $task, array $payload)
    {
        $taskstatus = new Taskstatus();
        $taskstatus->task_id = $payload['task_id'];
        $taskstatus->assignee_task_id = $payload['task_assignee_id'];
        $taskstatus->date = Carbon::now();
        $taskstatus->status = $payload['selectedOption'];
        $taskstatus->save();
    }
    public function update($taskstatus, $payload)
    {
        $taskstatus = Taskstatus::find($taskstatus);
        $taskstatus->date = Carbon::now();
        $taskstatus->status = $payload['selectedOption'];
        $taskstatus->save();
    }
}
