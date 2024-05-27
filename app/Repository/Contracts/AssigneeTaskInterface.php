<?php

namespace App\Repository\Contracts;

use App\Models\Module\Task\Task;
use App\Models\Module\Task\Sub\AssigneeTask;


interface AssigneeTaskInterface
{
    // Define your methods here
    public function create(Task|string $task, array $payload): AssigneeTask;
    public function update(Task|string $task, array $payload): AssigneeTask;
}
