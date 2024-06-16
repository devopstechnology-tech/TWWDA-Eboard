<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Meeting;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Meeting\Schedule;
use App\Repository\Contracts\ScheduleInterface;

class ScheduleController extends Controller
{
    public function __construct(private readonly ScheduleInterface $scheduleRepository)
    {
    }
    public function close($schedule): JsonResponse
    {
        // $this->authorize('delete', [Meeting::class, $meeting->id]);
        $this->scheduleRepository->closeSchedule($schedule);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), $schedule, Schedule::class);
    }
}