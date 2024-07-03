<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Module\Task\Task;
use App\Models\Module\Board\Board;
use App\Http\Resources\TaskResource;
use App\Models\Module\Meeting\Meeting;
use App\Repository\Contracts\TaskInterface;
use App\Repository\Contracts\AssigneeTaskInterface;

class TaskRepository extends BaseRepository implements TaskInterface
{
    // Implement the methods
    private $assigneetaskRepository;

    public function getAssigneeTaskRepository(): AssigneeTaskInterface
    {
        // Lazily load the AssigneeTaskRepository when needed
        return $this->assigneetaskRepository ??= resolve(AssigneeTaskInterface::class);
    }

    public function relationships()
    {
        return [
            'meeting',
            'meeting',
            'committee',
            'taskassignees.user',
        ];
    }
    public function getAll()
    {
        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Task::class, TaskResource::class, $filters);
    }
    public function getMeetingTasks($meeting)
    {
        $filters = [
            'meeting_id' => $meeting,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Task::class, TaskResource::class, $filters);
    }
    public function getTask(Task |string $task)
    {
        if (!($task instanceof Task)) {
            $task = Task::with($this->relationships())->findOrFail($task);
        }
        return $task->load($this->relationships());
    }
    public function updateTask(Meeting|string $meeting, array $payload): Task
    {

        $task = Task::find($payload['task_id']);
        $task->meeting_id     = $payload['meeting_id'];
        $task->board_id       = $payload['board_id'];
        $task->committee_id   = $payload['committee_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();
        if ($task->save()) {
            $task->taskassignees()->sync($payload['taskassignees']);
        }

        return $task;
    }
    public function createMeetingTask(Meeting|string $meeting, Board|string $board, array $payload): Task
    {
        // dd($payload['taskassignees']);
        $task = new Task();
        $task->meeting_id     = $payload['meeting_id'];
        $task->board_id       = $payload['board_id'];
        $task->committee_id   = $payload['committee_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();

        if ($task->save()) {
            $this->getAssigneeTaskRepository()->create($task, $payload);
        }
        return $task;
    }
    public function updateMeetingTask(Meeting|string $meeting, $board, Task $task, array $payload): Task
    {
        if (!($task instanceof Task)) {
            $task = Task::findOrFail($task);
        }
        $task->meeting_id     = $payload['meeting_id'];
        $task->board_id       = $payload['board_id'];
        $task->committee_id   = $payload['committee_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();
        if ($task->save()) {
            $this->getAssigneeTaskRepository()->update($task, $payload);
        }

        return $task;
    }
}