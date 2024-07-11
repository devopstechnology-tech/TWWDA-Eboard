<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\User;
use App\Models\Module\Discussion\Discussion;

interface DiscussionInterface
{
    // Define your methods here
    public function getAll();

    public function getUserDiscussions(User $user);
    public function createDiscussion(User $user, array $payload);
    public function updateDiscussion(User $user, Discussion $discussion, array $payload);
}