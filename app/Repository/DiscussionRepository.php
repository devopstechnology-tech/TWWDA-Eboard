<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use App\Http\Resources\DiscussionResource;
use App\Models\Module\Discussion\Discussion;
use App\Repository\Contracts\DiscussionInterface;

class DiscussionRepository extends BaseRepository implements DiscussionInterface
{
    // Implement the methods
    public function __construct(
        private readonly AttendanceInterface $attendanceRepository,
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
}
