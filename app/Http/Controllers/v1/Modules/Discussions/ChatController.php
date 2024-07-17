<?php

namespace App\Http\Controllers\v1\Modules\Discussions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Member\Member;
use App\Http\Requests\CreateChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Module\Discussions\Sub\Chat;
use App\Repository\Contracts\ChatInterface;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;

class ChatController extends Controller
{
    public function __construct(private readonly ChatInterface $chatRepository)
    {
    }


    public function store(CreateChatRequest $request, $user): JsonResponse
    {
        $chat = $this->chatRepository->createChat($user, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $chat, Chat::class);
    }
    public function update(UpdateChatRequest $request, Chat $chat): JsonResponse
    {
        $chat = $this->chatRepository->updateChat($chat, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $chat, Chat::class);
    }

}
