<?php

namespace App\Http\Controllers\v1\Modules\Discussion;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Discussion\Discussion;
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
}
