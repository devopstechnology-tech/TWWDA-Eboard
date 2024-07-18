<?php

namespace App\Repository\Contracts;

use App\Models\User;
use App\Models\System\Notification;

interface NotificationInterface
{
    // Define your methods here
    public function getAll();
    public function getLatest();
    public function getNotifications(User $user);
    public function updateNotification(Notification|string $notification, array $payload): Notification;
}