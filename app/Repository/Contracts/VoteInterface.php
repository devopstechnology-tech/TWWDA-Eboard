<?php

namespace App\Repository\Contracts;

use App\Models\Module\Poll\Poll;

interface VoteInterface
{
    // Define your methods here
    public function vote(Poll $poll, array $payload);
}
