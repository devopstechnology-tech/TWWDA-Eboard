<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use App\Http\Resources\DiscussionResource;
use App\Models\Module\Discussion\Discussion;
use App\Repository\Contracts\DiscussionInterface;
use App\Repository\Contracts\DiscussionAssigneeInterface;

class DiscussionRepository extends BaseRepository implements DiscussionInterface
{
    // Implement the methods
    public function __construct(
        private readonly DiscussionAssigneeInterface $discussionassigneeRepository,
    ) {
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
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        $discussion = new Discussion();
        $discussion->topic = $payload['topic'];
        $discussion->description = $payload['description'];
        $discussion->closestatus = $payload['closestatus'];
        $discussion->archivestatus = $payload['archivestatus'];
        $discussion->user_id = $user->id;
        $discussion->save();
        if ($discussion->save()) {
            $this->discussionassigneeRepository->create($user, $discussion, $payload);
        }
    }
    public function updateDiscussion(User $user, Discussion $discussion, array $payload)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        if (!($discussion instanceof Discussion)) {
            $discussion = User::findOrFail($discussion);
        }
    }
}
