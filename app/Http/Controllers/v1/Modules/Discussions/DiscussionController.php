<?php

namespace App\Http\Controllers\v1\Modules\Discussions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Discussions\Discussion;
use App\Http\Requests\CreateDiscussionRequest;
use App\Http\Requests\UpdateDiscussionRequest;
use App\Repository\Contracts\DiscussionInterface;

class DiscussionController extends Controller
{
    //
    public function __construct(private readonly DiscussionInterface $discussionRepository)
    {
    }
    public function index(): JsonResponse
    {
        $discussion = $this->discussionRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function userdiscussions(User $user): JsonResponse
    {
        $discussion = $this->discussionRepository->getUserDiscussions($user);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function store(CreateDiscussionRequest $request, User $user): JsonResponse
    {
        $discussion = $this->discussionRepository->createDiscussion($user, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function update(UpdateDiscussionRequest $request, Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussionRepository->updateDiscussion($discussion, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function updateMember(UpdateDiscussionRequest $request, Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussionRepository->updateDiscussionMember($discussion, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function leave(Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussionRepository->leaveDiscussion($discussion);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function close(Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussionRepository->closeDiscussion($discussion);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function delete(Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussionRepository->deleteDiscussion($discussion);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }

}
