<?php

namespace App\Http\Controllers\v1\Modules\Discussion;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Discussion\Discussion;
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
    public function creatediscussion(CreateDiscussionRequest $request, User $user): JsonResponse
    {
        $discussion = $this->discussionRepository->createDiscussion($user, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }
    public function updatediscussion(UpdateDiscussionRequest $request, User $user, Discussion $discussion): JsonResponse
    {
        $discussion = $this->discussionRepository->updateDiscussion($user, $discussion, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $discussion, Discussion::class);
    }

}
