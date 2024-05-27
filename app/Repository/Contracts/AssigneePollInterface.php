<?php

namespace App\Repository\Contracts;

use App\Models\Module\Poll\Poll;
use App\Models\Module\Poll\AssigneePoll;

interface AssigneePollInterface
{
    // Define your methods here
    public function create(Poll|string $poll, array $payload): AssigneePoll;
    public function update(Poll|string $poll, array $payload): AssigneePoll;


}