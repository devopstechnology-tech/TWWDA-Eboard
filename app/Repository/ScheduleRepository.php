<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enums\HeldEnum;
use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Meeting\Schedule;
use App\Repository\Contracts\ScheduleInterface;

class ScheduleRepository extends BaseRepository implements ScheduleInterface
{
    // Implement the methods
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical ScheduleResource for transformation
        $filters = [
            'user_id' => Auth::user()->id,
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Schedule::class, $filters);
    }

    public function get(Schedule|string $schedule): Schedule
    {
        if (!($schedule instanceof Schedule)) {
            $schedule = Schedule::findOrFail($schedule);
        }

        return $schedule;
    }
    public function createSchedule(Meeting|string $meeting, array $payload): void
    {
        $schedules = $payload['schedules'];
        foreach ($schedules as $scheduleData) {
            $schedule = new Schedule();
            $schedule->status     = StatusEnum::Inactive->value;
            $schedule->heldstatus = HeldEnum::Default->value;
            $schedule->date       = $scheduleData['date'];
            $schedule->start_time = $scheduleData['start_time'];
            $schedule->end_time   = $scheduleData['end_time'];
            $schedule->meeting_id = is_string($meeting) ? $meeting : $meeting->id; // Handle both string and object
            $schedule->save();
        }
    }

    public function updateSchedule(Meeting|string $meeting, array $payload): void
    {
        $schedules = $payload['schedules'];
        foreach ($schedules as $scheduleData) {
            // Check if a schedule with the provided ID exists
            $schedule = Schedule::find($scheduleData['id']);
            if ($schedule) {
                // If found, create a new instance of the Schedule model
                $schedule->status      = $scheduleData['status'];
                $schedule->heldstatus  = $scheduleData['heldstatus'];
            }


            if (!$schedule) {
                // If not found, create a new instance of the Schedule model
                $schedule = new Schedule();
                $schedule->status  = StatusEnum::Inactive->value;
                $schedule->heldstatus  = HeldEnum::Default->value;
            }
            $schedule->date       = $scheduleData['date'];
            $schedule->start_time = $scheduleData['start_time'];
            $schedule->end_time   = $scheduleData['end_time'];
            $schedule->meeting_id = is_string($meeting) ? $meeting : $meeting->id; // Handle both string and object
            $schedule->save();
        }
    }
    public function update(Schedule|string $schedule, array $payload): Schedule
    {
        if (!($schedule instanceof Schedule)) {
            $schedule = Schedule::findOrFail($schedule);
        }
        return $schedule;
    }
    public function updateMembers(Schedule|string $schedule, array $payload): void
    {
        if (!($schedule instanceof Schedule)) {
            $schedule = Schedule::findOrFail($schedule);
        }

        // Ensure we have an authenticated user before proceeding
        if (!Auth::check()) {
            //     return response()->json(['message' => 'User not authenticated'], 401);
        }
        $userId = Auth::id(); // Get the current authenticated user's ID
        $userIds = $payload['members'];

        //     // Filter out null values and ensure unique IDs
        $userIds = array_unique(array_filter($userIds, function ($id) {
            return !is_null($id) && $id !== '';
        }));

        Log::info('Array content 2:', $userIds);
        //     // Ensure the current user's ID is included
        if (!in_array($userId, $userIds)) {
            $userIds[] = $userId;
        }
        //     // Sync the member associations, including the current user
        $schedule->members()->sync($userIds);
    }

    public function delete(Schedule|string $schedule): bool
    {
        if (!($schedule instanceof Schedule)) {
            $schedule = Schedule::findOrFail($schedule);
        }

        return $schedule->delete();
    }
}