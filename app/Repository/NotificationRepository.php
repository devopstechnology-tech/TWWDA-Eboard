<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\BaseRepository;
use App\Models\System\Notification;
use App\Http\Resources\NotificationResource;
use App\Repository\Contracts\NotificationInterface;

class NotificationRepository extends BaseRepository implements NotificationInterface
{
    // Implement the methods
    public function relationships()
    {
        return [
            'notifiable',
        ];
    }
    public function getAll()
    {
        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Notification::class, NotificationResource::class, $filters);
    }
    public function getNotifications(User $user)
    {
        $filters = [
            'notifiable_id' => $user->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Notification::class, NotificationResource::class, $filters);
    }
    public function updateNotification(Notification|string $notification, array $payload): Notification
    {
        $notification = Notification::find($payload['id']);
        $notification->markAsRead();

        return $notification;
    }
}