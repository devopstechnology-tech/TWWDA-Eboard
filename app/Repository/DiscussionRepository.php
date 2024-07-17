<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use App\Enums\CloseEnum;
use App\Http\Resources\DiscussionResource;
use App\Repository\Contracts\ChatInterface;
use App\Models\Module\Discussions\Discussion;
use App\Repository\Contracts\DiscussionInterface;
use App\Repository\Contracts\DiscussionAssigneeInterface;

class DiscussionRepository extends BaseRepository implements DiscussionInterface
{
    // Implement the methods
    private $discussionAssigneeRepository;
    private $chatRepository;

    public function getDiscussionAssigneeRepository(): DiscussionAssigneeInterface
    {
        return $this->discussionAssigneeRepository ??= resolve(DiscussionAssigneeInterface::class);
    }   

    public function getChatRepository(): ChatInterface
    {
        return $this->chatRepository ??= resolve(ChatInterface::class);
    }

    public function relationships()
    {
        return [
            'author',
            'assignees',
            'chats',
        ];
    }
    public function getAll()
    {
        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Discussion::class, DiscussionResource::class, $filters);
    }
    public function getUserDiscussions(User $user)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        $userId = $user->id;
        $filters = [
            'whereHas' => [
                'assignees' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ],
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Discussion::class, DiscussionResource::class, $filters);
    }
    public function createDiscussion(User $user, array $payload)
    {
        // dd($payload);
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        $discussion = new Discussion();
        $discussion->topic = $payload['topic'];
        $discussion->description = $payload['description'];
        $discussion->closestatus = $payload['closestatus'];
        $discussion->archivestatus = $payload['archivestatus'];
        $discussion->user_id = $user->id;
        $discussion->dassignees = $payload['discussionassignees'];
        $discussion->save();
        if ($discussion->save()) {
            $this->getDiscussionAssigneeRepository()->create($user, $discussion, $payload);
        }
    }
    public function updateDiscussion(Discussion $discussion, array $payload)
    {
        if (!($discussion instanceof Discussion)) {
            $discussion = discussion::findOrFail($discussion);
        }
        $discussion->topic = $payload['topic'];
        $discussion->description = $payload['description'];
        $discussion->closestatus = $payload['closestatus'];
        $discussion->archivestatus = $payload['archivestatus'];
        $discussion->dassignees = $payload['discussionassignees'];
        $discussion->save();
        if ($discussion->save()) {
            $this->getDiscussionAssigneeRepository()->update($discussion, $payload);
        }
    }
    public function updateDiscussionMember(Discussion $discussion, array $payload)
    {
        if (!($discussion instanceof Discussion)) {
            $discussion = discussion::findOrFail($discussion);
        }
        if ($discussion) {
            $this->getDiscussionAssigneeRepository()->update($discussion, $payload);
        }
    }
    public function leaveDiscussion(Discussion $discussion)
    {
        if (!($discussion instanceof Discussion)) {
            $discussion = discussion::findOrFail($discussion);
        }
        $this->getDiscussionAssigneeRepository()->leave($discussion);
    }
    public function closeDiscussion(Discussion $discussion)
    {
        if (!($discussion instanceof Discussion)) {
            $discussion = discussion::findOrFail($discussion);
        }
        $discussion->closestatus = CloseEnum::Closed->value;
        $discussion->save();
    }
    public function deleteDiscussion(Discussion $discussion)
    {
        if (!($discussion instanceof Discussion)) {
            $discussion = discussion::findOrFail($discussion);
        }
        $this->getDiscussionAssigneeRepository()->delete($discussion);
        $this->getChatRepository()->delete($discussion);
        $discussion->delete();
        // $discussion->forceDelete();
    }
}
