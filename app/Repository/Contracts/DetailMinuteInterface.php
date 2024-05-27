<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Minute;

interface DetailMinuteInterface
{
    // Define your methods here
    public function create(Minute|string $minute, array $payload): void;
    public function update(Minute|string $minute, array $payload): void;
    public function createSubMinute(Minute|string $minute, array $payload): void;
    public function updateSubMinute(Minute|string $minute, array $payload): void;
}
