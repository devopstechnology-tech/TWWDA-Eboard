<?php

namespace App\Http\Controllers\v1\Modules\Conflict;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Conflict\Conflict;
use App\Http\Requests\CreateConflictRequest;
use App\Http\Requests\UpdateConflictRequest;
use App\Repository\Contracts\ConflictInterface;

class ConflictController extends Controller
{
    public function __construct(private readonly ConflictInterface $conflictRepository)
    {
    }
    public function index(): JsonResponse
    {
        $conflicts = $this->conflictRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $conflicts, Conflict::class);
    }
    public function getmeetingconflicts($meeting): JsonResponse
    {
        $conflicts = $this->conflictRepository->getMeetingConflicts($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $conflicts, Conflict::class);
    }

    public function createmeetingconflict(CreateConflictRequest $request, Meeting $meeting): JsonResponse
    {
        $conflict = $this->conflictRepository->createMeetingConflict($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $conflict, Conflict::class);
    }
public function updatemeetingconflict(UpdateConflictRequest $request, Meeting $meeting, Conflict $conflict): JsonResponse
    {
        $conflict = $this->conflictRepository->updateMeetingConflict($meeting, $conflict, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $conflict, Conflict::class);
    }


}
