<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Poll\Poll;

interface OptionInterface
{
    // Define your methods here
    public function create(Poll|string $poll, array $payload): void;
    public function update(Poll|string $poll, array $payload): void;
}
