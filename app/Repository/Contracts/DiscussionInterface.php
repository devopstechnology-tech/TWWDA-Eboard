<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\User;

interface DiscussionInterface
{
    // Define your methods here
    public function getAll();

    public function getUserDiscussions(User $user);
}