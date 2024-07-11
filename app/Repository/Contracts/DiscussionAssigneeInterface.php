<?php

namespace App\Repository\Contracts;

use App\Models\User;
use App\Models\Module\Discussion\Discussion;

interface DiscussionAssigneeInterface
{
    // Define your methods here
    public function create(User $user, Discussion $discussion, array $payload);
}
