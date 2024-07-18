<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Poll;

use Illuminate\Http\Response;
use App\Models\Module\Poll\Poll;
use Illuminate\Http\JsonResponse;
use App\Models\Module\Board\Board;
use App\Http\Controllers\Controller;
use App\Models\Module\Meeting\Meeting;
use App\Http\Requests\CreatePollRequest;
use App\Http\Requests\CreateVoteRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\PollInterface;

class PollController extends Controller
{
    public function __construct(private readonly PollInterface $pollRepository)
    {
    }
    public function index(): JsonResponse
    {
        $polls = $this->pollRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function latest(): JsonResponse
    {
        $polls = $this->pollRepository->getLatest();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function userpolls(): JsonResponse
    {
        $polls = $this->pollRepository->getUserPolls();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function getmeetingpolls($meeting): JsonResponse
    {
        $polls = $this->pollRepository->getMeetingPolls($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function show($meeting): JsonResponse
    {
        $polls = $this->pollRepository->getMeetingPolls($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function createmeetingpoll(CreatePollRequest $request, Meeting $meeting): JsonResponse
    {
        $poll = $this->pollRepository->createMeetingPoll($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }
    
    public function updatemeetingpoll(UpdatePollRequest $request, Meeting $meeting, Poll $poll): JsonResponse
    {
        $poll = $this->pollRepository->updateMeetingPoll($meeting, $poll, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }
    //board
    public function getboardpolls($board): JsonResponse
    {
        $polls = $this->pollRepository->getBoardPolls($board);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function createboardpoll(CreatePollRequest $request, Board $board): JsonResponse
    {
        $poll = $this->pollRepository->createBoardPoll($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }
    
    public function updateboardpoll(UpdatePollRequest $request, Poll $poll): JsonResponse
    {
        $poll = $this->pollRepository->updateBoardPoll($poll, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }
    //committee
    public function getcommitteepolls($committee): JsonResponse
    {
        $polls = $this->pollRepository->getCommitteePolls($committee);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $polls, Poll::class);
    }
    public function createcommitteepoll(CreatePollRequest $request, Committee $committee): JsonResponse
    {
        $poll = $this->pollRepository->createCommitteePoll($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }
    
    public function updatecommitteepoll(UpdatePollRequest $request, Poll $poll): JsonResponse
    {
        $poll = $this->pollRepository->updateCommitteePoll($poll, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }
    //vote
    public function votepoll(CreateVoteRequest $request, Poll $poll): JsonResponse
    {
        $poll = $this->pollRepository->VotePoll($poll, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $poll, Poll::class);
    }



}
