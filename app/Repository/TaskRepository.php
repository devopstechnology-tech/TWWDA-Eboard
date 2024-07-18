<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Module\Task\Task;
use App\Models\Module\Board\Board;
use App\Repository\BaseRepository;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Task\Sub\Taskstatus;
use App\Repository\Contracts\TaskInterface;
use App\Repository\Contracts\TaskstatusInterface;
use App\Repository\Contracts\AssigneeTaskInterface;

class TaskRepository extends BaseRepository implements TaskInterface
{
    // Implement the methods
    private $assigneetaskRepository;
    private $taskstatusRepository;

    public function getAssigneeTaskRepository(): AssigneeTaskInterface
    {
        // Lazily load the AssigneeTaskRepository when needed
        return $this->assigneetaskRepository ??= resolve(AssigneeTaskInterface::class);
    }
    public function getTaskstatusRepository(): TaskstatusInterface
    {
        // Lazily load the AssigneeTaskRepository when needed
        return $this->taskstatusRepository ??= resolve(TaskstatusInterface::class);
    }

    public function relationships()
    {
        return [
            'meeting',
            'committee',
            'taskassignees',
            'taskstatuses',
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
    public function getUserTasks()
    {
        // Get the task IDs for the authenticated user
        $taskIDs = $this->getAssigneeTaskRepository()->getTasksAuth();
        $filters = [
            'whereIn' => ['id' => $taskIDs],
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Task::class, TaskResource::class, $filters);
    }
    public function getLatest()
{  
    // Get the task IDs for the authenticated user
    $taskIDs = $this->getAssigneeTaskRepository()->getTasksAuth();
    $orderBy = ['field' => 'created_at', 'direction' => 'asc'];

    // Fetch the total count of tasks
    $totalCount = Task::whereIn('id', $taskIDs)->count();

    // Fetch the latest tasks with relationships
    $tasks = Task::whereIn('id', $taskIDs)
        ->with($this->relationships())
        ->orderBy($orderBy['field'], $orderBy['direction'])
        ->limit(5)
        ->get();

    // Prepare the data to return
    $data = [
        'count' => $totalCount,
        'tasks' => $tasks,
    ];

    return $data;
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
    public function getMeetingTasks($meeting)
    {
        $filters = [
            'meeting_id' => $meeting,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Task::class, TaskResource::class, $filters);
    }
    public function createMeetingTask(Meeting|string $meeting, array $payload): Task
    {
        // dd($payload['taskassignees']);
        $task = new Task();
        $task->meeting_id     = $payload['meeting_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();

        if ($task->save()) {
            $payload['entity_type'] = get_class($meeting); // Pass the entity type
            $this->getAssigneeTaskRepository()->create($task, $payload);
        }
        return $task;
    }
    public function updateMeetingTask(Meeting|string $meeting, Task $task, array $payload): Task
    {
        if (!($task instanceof Task)) {
            $task = Task::findOrFail($task);
        }
        $task->meeting_id     = $payload['meeting_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();
        if ($task->save()) {
            $payload['entity_type'] = get_class($meeting); // Pass the entity type
            $this->getAssigneeTaskRepository()->update($task, $payload);
        }

        return $task;
    }

    //board
    public function getBoardTasks($board)
    {
        $filters = [
            'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Task::class, TaskResource::class, $filters);
    }
    public function createBoardTask(Board $board, array $payload): Task
    {
        // dd($payload['taskassignees']);
        $task = new Task();
        $task->board_id       = $payload['board_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();

        if ($task->save()) {
            $payload['entity_type'] = get_class($board); // Pass the entity type
            $this->getAssigneeTaskRepository()->create($task, $payload);
        }
        return $task;
    }
    public function updateBoardTask(Task $task, array $payload): Task
    {
        if (!($task instanceof Task)) {
            $task = Task::findOrFail($task);
        }
        $task->board_id       = $payload['board_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();
        if ($task->save()) {
            $payload['entity_type'] = get_class($task->board);
            $this->getAssigneeTaskRepository()->update($task, $payload);
        }
        return $task;
    }
    //committee
    public function getCommitteeTasks($committee)
    {
        $filters = [
            'committee_id' => $committee,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Task::class, TaskResource::class, $filters);
    }
    public function createCommitteeTask(Committee $committee, array $payload): Task
    {
        // dd($payload['taskassignees']);
        $task = new Task();
        $task->committee_id   = $payload['committee_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();

        if ($task->save()) {
            $payload['entity_type'] = get_class($task->committee);
            $this->getAssigneeTaskRepository()->create($task, $payload);
        }
        return $task;
    }
    public function updateCommitteeTask(Task $task, array $payload): Task
    {
        if (!($task instanceof Task)) {
            $task = Task::findOrFail($task);
        }
        $task->committee_id   = $payload['committee_id'];
        $task->title          = $payload['title'];
        $task->duedate        = $payload['duedate'];
        $task->description    = $payload['description'];
        $task->assigneetype   = $payload['assigneetype'];
        $task->assigneestatus = $payload['assigneestatus'];
        $task->status         = $payload['status'];
        $task->save();
        if ($task->save()) {
            $payload['entity_type'] = get_class($task->committee);
            $this->getAssigneeTaskRepository()->update($task, $payload);
        }
        return $task;
    }
    public function WorkTask(Task $task, array $payload)
    {
        if (!($task instanceof Task)) {
            $task = Task::findOrFail($task);
        }

        $tasking = $this->getTaskstatusRepository()->tasking($task, $payload);       
    }

    public function updateWorkTask($taskstatus, array $payload)
    {
        $tasking = $this->getTaskstatusRepository()->update($taskstatus, $payload);       
    }
}