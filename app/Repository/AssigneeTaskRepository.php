<?php

namespace App\Repository;


use App\Models\Module\Task\Task;
use App\Repository\BaseRepository;
use App\Repository\Contracts\TaskInterface;
use App\Models\Module\Task\Sub\AssigneeTask;
use App\Repository\Contracts\AssigneeTaskInterface;

class AssigneeTaskRepository extends BaseRepository implements AssigneeTaskInterface
{
    private $taskRepository;

    public function getTaskRepository(): TaskInterface
    {
        // Lazily load the AssigneeTaskRepository when needed
        return $this->taskRepository ??= resolve(TaskInterface::class);
    }

    // Implement the methods
    public function create(Task|string $task, array $payload): AssigneeTask
    {
        if ($payload['assigneetype'] === 'all_members') {
            return $this->createAllMembers($task, $payload);
        } else {
            $memberships = $payload['taskassignees'];
            foreach ($memberships as $membership) {
                $assigneetask                = new AssigneeTask();
                $assigneetask->task_id       = $task->id;
                $assigneetask->membership_id = $membership['id'];
                $assigneetask->save();
            }
        }
        return AssigneeTask::firstWhere('task_id', $task->id);
    }

    public function createAllMembers(Task|string $task, array $payload)
    {
        // $existingAssignees = AssigneeTask::where('task_id', $task->id)->forceDelete();
        $existingAssignees = AssigneeTask::where('task_id', $task->id)
            ->get()->each->forceDelete();
        $singletask = $this->getTaskRepository()->getTask($task);
        $meeting = $singletask->meeting;
        if ($meeting) {
            $memberships = $meeting->memberships()->get();
            $membershipsMap = $memberships->keyBy('id')->toArray();
            foreach ($membershipsMap as $membershipsmap) {
                // dd($membershipsmap);
                // Optionally delete or deactivate unused assignees
                $assigneetask = new AssigneeTask();
                $assigneetask->task_id = $task->id;
                $assigneetask->membership_id = $membershipsmap['id'];
                $assigneetask->save();
            }
        }
        return AssigneeTask::firstWhere('task_id', $task->id);
    }

    public function update(Task|string $task, array $payload): AssigneeTask
    {
        if ($payload['assigneetype'] === 'all_members') {
            // dd('we here '/);
            return $this->createAllMembers($task, $payload);
        } else {
            $existingAssignees = AssigneeTask::where('task_id', $task->id)->get();
            $existingAssigneesMap = $existingAssignees->keyBy('membership_id')->toArray();
            // Process each assignee data from the payload
            foreach ($payload['taskassignees'] as $potentialAssignee) {
                // dd($potentialAssignee['membership_id'], isset($existingAssigneesMap[$potentialAssignee['membership_id']]));
                if (isset($existingAssigneesMap[$potentialAssignee['membership_id']])) {
                    // If the membership ID exists, update other details if needed
                    // For example, update something or just touch it to update timestamps
                    $assigneetask = AssigneeTask::where('task_id', $task->id)
                        ->where('membership_id', $potentialAssignee['membership_id'])
                        ->first();
                    $assigneetask->touch();
                    // Remove from the existing list to track which are still in use
                    unset($existingAssigneesMap[$potentialAssignee['membership_id']]);
                } else {
                    // If the membership ID does not exist, create a new assignee
                    $assigneetask = new AssigneeTask();
                    $assigneetask->task_id = $task->id;
                    $assigneetask->membership_id = $potentialAssignee['membership_id'];
                    $assigneetask->save();
                }
            }
            // Any remaining items in $existingAssigneesMap are not in the new payload and should be considered for deletion
            $deleteunusedMembershipId = $this->deleteonForce($task, $existingAssigneesMap);
            return AssigneeTask::firstWhere('task_id', $task->id);
        }
    }
    public function deleteonForce(Task|string $task, $existingAssigneesMap)
    {
        foreach ($existingAssigneesMap as $unusedMembershipId => $unusedAssignee) {
            // Optionally delete or deactivate unused assignees
            AssigneeTask::where('task_id', $task->id)
                ->where('membership_id', $unusedMembershipId)
                ->forceDelete();  // Or another action as needed
        }
    }
}
