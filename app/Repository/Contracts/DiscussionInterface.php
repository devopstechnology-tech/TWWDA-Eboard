<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\User;
use App\Models\Module\Discussions\Discussion;

interface DiscussionInterface
{
    // Define your methods here
    public function getAll();

    public function getUserDiscussions(User $user);
    public function createDiscussion(User $user, array $payload);
    public function updateDiscussion(Discussion $discussion, array $payload);
    public function updateDiscussionMember(Discussion $discussion, array $payload);
    public function leaveDiscussion(Discussion $discussion);
    public function closeDiscussion(Discussion $discussion);
    public function deleteDiscussion(Discussion $discussion);
}