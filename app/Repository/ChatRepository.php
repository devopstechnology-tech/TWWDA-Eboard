<?php

namespace App\Repository;

use App\Models\User;
use App\Enums\EditEnum;
use App\Repository\BaseRepository;
use App\Http\Resources\ChatResource;
use App\Models\Module\Discussions\Sub\Chat;
use App\Repository\Contracts\ChatInterface;
use App\Models\Module\Discussions\Discussion;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;
use App\Repository\Contracts\DiscussionAssigneeInterface;

class ChatRepository extends BaseRepository implements ChatInterface
{
    private $discussionAssigneeRepository;

    public function getDiscussionAssigneeRepository(): DiscussionAssigneeInterface
    {
        // Lazily load the AssigneeTaskRepository when needed
        return $this->discussionAssigneeRepository ??= resolve(DiscussionAssigneeInterface::class);
    }

    public function relationships()
    {
        return [
            'discussion',
            'sender',
            'receiver',
        ];
    }
    public function getAllDiscusionChats($discussion_id)
    {
        $filters = [
            'discussion_id' => $discussion_id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Chat::class, ChatResource::class, $filters); 
    }
    // Implement the methods
    public function createChat($user, array $payload)
    {
        $chat = new Chat();
        $chat->discussion_id = $payload['discussion_id'];
        $chat->assignee_sender_id = ($this->getDiscussionAssigneeRepository()->getAuthAssignee($user, $payload))->id;
        $chat->message = $payload['message'];
        $chat->save();
        return $this->getAllDiscusionChats($payload['discussion_id']);
    }
    public function updateChat(Chat $chat, array $payload)
    {
        if (!($chat instanceof Chat)) {
            $chat = Chat::findOrFail($chat);
        }
        $chat->message = $payload['message'];
        $chat->editstatus = EditEnum::Edited->value;
        $chat->save();

        return $this->getAllDiscusionChats($payload['discussion_id']);
    }
    public function delete(Discussion $discussion)
    {
        if (!($discussion instanceof Discussion)) {
            $discussion = Discussion::findOrFail($discussion);
        }
        Chat::where('discussion_id', $discussion->id)->delete();
        return true;
    }
}
