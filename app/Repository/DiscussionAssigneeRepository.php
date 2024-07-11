<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\BaseRepository;
use App\Models\Module\Discussion\Discussion;
use App\Models\Module\Discussion\Sub\DiscussionAssignee;
use App\Repository\Contracts\DiscussionAssigneeInterface;

class DiscussionAssigneeRepository extends BaseRepository implements DiscussionAssigneeInterface
{
    // Implement the methods
    public function create(User $user, Discussion $discussion, array $payload)
    {
        $discussionassignee = new DiscussionAssignee();
        $discussionassignee->discussion_id = $discussion->id;
        $discussionassignee->user_id       = $payload['user_id'];
        $discussionassignee->assignee_id   = $payload['assignee_id'];
        $discussionassignee->assignee_type = $payload['assignee_type'];
        $discussionassignee->save();
    }
}
