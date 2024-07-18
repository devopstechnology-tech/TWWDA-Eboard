<?php

namespace App\Repository;

use App\Models\Module\Task\Task;
use App\Models\Module\Board\Board;
use App\Repository\BaseRepository;
use App\Models\Module\Member\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\TaskInterface;
use App\Models\Module\Task\Sub\AssigneeTask;
use App\Repository\Contracts\AssigneeTaskInterface;

class AssigneeTaskRepository extends BaseRepository implements AssigneeTaskInterface
{
    private $taskRepository;

    public function getTaskRepository(): TaskInterface
    {
        return $this->taskRepository ??= resolve(TaskInterface::class);
    }
    public function getTasksAuth()
    {
        $assigneeTasks = AssigneeTask::with('assignable')->get();
    
        $taskIDs = $assigneeTasks->filter(function ($assigneeTask) {
            return $assigneeTask->assignable?->user_id === Auth::id();
        })->pluck('task_id')->toArray();
    
        return $taskIDs;
    }
    public function create(Task|string $task, array $payload): AssigneeTask
    {
        $entityType = $payload['entity_type'];
        [$assignableIds, $assignableType, $columnType] = $this->getAssignableDetails($entityType, $task);

        if ($payload['assigneetype'] === 'all_members') {
            AssigneeTask::where('task_id', $task->id)->forceDelete();
            return $this->createAllMembers($task, $assignableIds, $assignableType, $payload);
        } else {
            foreach ($payload['taskassignees'] as $assignable) {
                $assigneeTask = new AssigneeTask();
                $assigneeTask->task_id = $task->id;
                $assigneeTask->assignable_id = $assignable[$columnType];
                $assigneeTask->assignable_type = $assignableType;
                $assigneeTask->save();
            }
        }
        return AssigneeTask::firstWhere('task_id', $task->id);
    }

    public function createAllMembers(Task $task, $assignableIds, $assignableType, array $payload)
    {
        foreach ($assignableIds as $assignableId) {
            $assigneeTask = new AssigneeTask();
            $assigneeTask->task_id = $task->id;
            $assigneeTask->assignable_id = $assignableId;
            $assigneeTask->assignable_type = $assignableType;
            $assigneeTask->save();
        }
        return AssigneeTask::firstWhere('task_id', $task->id);
    }

    public function update(Task|string $task, array $payload): AssigneeTask
{
    $entityType = $payload['entity_type'];
    [$assignableIds, $assignableType, $columnType] = $this->getAssignableDetails($entityType, $task);
    AssigneeTask::where('task_id', $task->id)->forceDelete();
    if ($payload['assigneetype'] === 'all_members') {
        return $this->createAllMembers($task, $assignableIds, $assignableType, $payload);
    } else {
        foreach ($payload['taskassignees'] as $potentialAssignee) { 
            // dd($columnType, $assignableType, $potentialAssignee);  
                    $assigneeTask = new AssigneeTask();
                    $assigneeTask->task_id = $task->id;
                    $assigneeTask->assignable_id = $potentialAssignee[$columnType];
                    $assigneeTask->assignable_type = $assignableType; // Ensure $assignableType is defined
                    $assigneeTask->save();
            }
            return AssigneeTask::firstWhere('task_id', $task->id); // Ensure a default object is returned if nothing found
        }

}


protected function getAssignableDetails($entityType, Task|string $task): array
{
    $assignableIds = [];
    $assignableType = null;
    $columnType = null;

    switch ($entityType) {
        case Board::class:
            $board = Board::with('members')->findOrFail($task->board_id);
            $assignableIds = $board->members->pluck('id')->toArray();
            $assignableType = Member::class;
            $columnType = 'member_id';
            break;

        case Meeting::class:
            $meeting = Meeting::with('memberships')->findOrFail($task->meeting_id);
            $assignableIds = $meeting->memberships->pluck('id')->toArray();
            $assignableType = Membership::class;
            $columnType = 'membership_id';
            break;

        case Committee::class:
            $committee = Committee::with('members')->findOrFail($task->committee_id);
            $assignableIds = $committee->members->pluck('id')->toArray();
            $assignableType = Member::class;
            $columnType = 'member_id';
            break;

        default:
            throw new \Exception("Invalid entity type: {$entityType}");
    }

    return [$assignableIds, $assignableType, $columnType];
    }
}
