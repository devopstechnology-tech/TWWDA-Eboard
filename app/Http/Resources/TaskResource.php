<?php

declare(strict_types=1);

namespace App\Http\Resources;

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
            'assigneetype' => $this->resource->assigneetype,
            'assigneestatus' => $this->resource->assigneestatus,
            'taskassignees' => $this->resource->taskassignees->map(function ($taskassignee) {
                // dd($taskassignee);
                return [
                    'id' => $taskassignee->pivot->id, // Accessing pivot data
                    'membership_id' => $taskassignee->pivot->membership_id ?? null, // Accessing pivot data
                    'task_id' => $taskassignee->pivot->task_id ?? null,
                    'user' => [
                        'id' => $taskassignee->user->id ?? null,  // Ensure user is loaded
                        'full_name' => $taskassignee->user->full_name ?? 'N/A',  // Check if user is loaded and full_name is available
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
