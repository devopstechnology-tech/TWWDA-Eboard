<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Minute;

interface MinuteInterface
{
    // Define your methods here
    public function getAll();

    public function getScheduleMinutes($schedule);
    public function get(Minute|string $minute): Minute;
    public function create($schedule, array $payload);

    public function update(Minute|string $minute, array $payload): Minute;
    public function createsubminute($schedule, array $payload);
    public function updatesubminute($subminute, array $payload);

    public function ceoApprovalMinute(Minute|string $minute);
    public function AcceptceoApprovalMinute(Minute|string $minute);
    public function publishMinute(Minute|string $minute): bool;
    public function signaturesMinute(Minute|string $minute): bool;
    public function deleteMinute(Minute|string $minute): bool;
}