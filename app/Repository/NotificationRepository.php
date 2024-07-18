<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\BaseRepository;
use App\Models\System\Notification;
use Illuminate\Support\Facades\Auth;
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
            // 'limit' => 4,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Notification::class, NotificationResource::class, $filters);
    }
    public function getNotifications(User $user)
    {
        $filters = [
            // 'limit' => 4,
            'notifiable_id' => $user->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Notification::class, NotificationResource::class, $filters);
    }
    public function getLatest()
    {
        $orderBy = ['field' => 'created_at', 'direction' => 'asc'];
        // Fetch the data
        $totalCount = Notification::where('notifiable_id', Auth::user()->id)->count();
        $notifications = Notification::with($this->relationships())
            ->where('notifiable_id', Auth::user()->id)
            ->orderBy($orderBy['field'], $orderBy['direction'])
            ->limit(5)
            ->get();

            $data =  [
                'count' => $totalCount,
                'notifications' => $notifications,
            ];
            return $data;
    }
    public function updateNotification(Notification|string $notification, array $payload): Notification
    {
        $notification = Notification::find($payload['id']);
        $notification->markAsRead();

        return $notification;
    }
}