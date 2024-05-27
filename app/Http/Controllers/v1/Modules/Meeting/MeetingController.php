<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMeetingRequest;
use App\Http\Requests\UpdateMeetingMemberRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Module\Meeting\Meeting;
use App\Repository\Contracts\MeetingInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private readonly MeetingInterface $meetingRepository)
    {
    }
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Meeting::class);
        $meeting = $this->meetingRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $meeting, Meeting::class);
    }
    public function boardmeetings($meeting): JsonResponse
    {
        // $this->authorize('viewAny', Meeting::class);
        $meeting = $this->meetingRepository->getBoardMeetings($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $meeting, Meeting::class);
    }
    public function committeemeetings($meeting): JsonResponse
    {
        // $this->authorize('viewAny', Meeting::class);
        $meeting = $this->meetingRepository->getCommitteeMeetings($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $meeting, Meeting::class);
    }

    public function show(Meeting $meeting): JsonResponse
    {
        // $this->authorize('view', [Meeting::class, $meeting->id]);
        $meeting = $this->meetingRepository->get($meeting);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $meeting, Meeting::class);
    }
    public function boardmeeting($meeting): JsonResponse
    {
        // $this->authorize('view', [Meeting::class, $meeting->id]);
        $meeting = $this->meetingRepository->getboardMeeting($meeting);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $meeting, Meeting::class);
    }
    public function committeemeeting($meeting): JsonResponse
    {
        // $this->authorize('view', [Meeting::class, $meeting->id]);
        $meeting = $this->meetingRepository->getcommitteeMeeting($meeting);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $meeting, Meeting::class);
    }

    public function store(CreateMeetingRequest $request): JsonResponse
    {
        // $this->authorize('create', [Meeting::class]);
        $meeting = $this->meetingRepository->create($request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $meeting);
    }

    public function update(UpdateMeetingRequest $request, $meeting): JsonResponse
    {
        // dd($meeting);
        // $this->authorize('update', [Meeting::class, $meeting->id]);
        $meeting = $this->meetingRepository->update($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $meeting);
    }
    public function updatememmbers(UpdateMeetingMemberRequest $request, Meeting $meeting): JsonResponse
    {
        // $this->authorize('update', [Meeting::class, $meeting->id]);
        $meeting = $this->meetingRepository->updateMembers($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $meeting);
    }

    public function publish($meeting): JsonResponse
    {
        // $this->authorize('delete', [Meeting::class, $meeting->id]);
        $this->meetingRepository->publishMeeting($meeting);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), $meeting, Meeting::class);
    }
    public function destroy(Meeting $meeting): JsonResponse
    {
        $this->authorize('delete', [Meeting::class, $meeting->id]);
        $this->meetingRepository->delete($meeting);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }
}
