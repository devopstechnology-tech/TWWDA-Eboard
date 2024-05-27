<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Minute;

interface MinuteInterface
{
    // Define your methods here
    public function getAll();

    public function getMeetingMinutes($meeting);
    public function get(Minute|string $minute): Minute;
    public function create($meeting, array $payload);

    public function update(Minute|string $minute, array $payload): Minute;
    public function createsubminute($meeting, array $payload);
    public function updatesubminute($subminute, array $payload);


    public function delete(Minute|string $minute): bool;


}
