<?php

namespace App\Repository\Contracts;

use App\Models\Module\Task\Task;
use App\Models\Module\Task\Sub\Taskstatus;

interface TaskstatusInterface
{
    // Define your methods here]
    public function tasking(Task $task, array $payload);
    public function update($taskstatus, $payload); 
}
