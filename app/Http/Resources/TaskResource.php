<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Module\Member\Member;
use App\Models\Module\Member\Membership;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class TaskResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
{
    return [
        'id' => $this->resource->getRouteKey(),
        'meeting_id' => $this->resource->meeting_id,
        'board_id' => $this->resource->board_id,
        'committee_id' => $this->resource->committee_id,
        'title' => $this->resource->title,
        'duedate' => $this->resource->duedate,
        'description' => $this->resource->description,
        'status' => $this->resource->status,
        'taskstatuses' => $this->resource->taskstatuses,

        'assigneetype' => $this->resource->assigneetype,
        'assigneestatus' => $this->resource->assigneestatus,
        'taskassignees' => $this->resource->taskassignees->map(function ($taskassignee) {
            // dd($taskassignee->assignable);
                    return [
                        'id' => $taskassignee->id,
                        'assignable' => [
                            'type' => class_basename($taskassignee->assignable_type),  // Extracts simple class name
                            'details' => $taskassignee->assignable,
                        ],
                        'task_id' => $taskassignee->task_id,
                        'user' => [
                            'id' =>  $taskassignee->assignable->user->id,
                            'full_name' =>  $taskassignee->assignable->user->full_name,
                        ],
                    ];
                }),
        ];
    }


    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
        ];
    }
}
