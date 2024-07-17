<?php

namespace App\Repository\Contracts;

use App\Models\User;
use App\Models\Module\Discussions\Discussion;

interface DiscussionAssigneeInterface
{
    // Define your methods here
    public function create(User $user, Discussion $discussion, array $payload);
    public function update(Discussion $discussion, array $payload);
    public function delete(Discussion $discussion);
    public function leave(Discussion $discussion);
    public function getAuthAssignee($user, array $payload);
   
}
