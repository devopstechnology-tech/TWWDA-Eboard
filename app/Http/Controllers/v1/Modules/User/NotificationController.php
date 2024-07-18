<?php

namespace App\Http\Controllers\v1\Modules\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\System\Notification;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateNotificationRequest;
use App\Repository\Contracts\NotificationInterface;

class NotificationController extends Controller
{
    public function __construct(private readonly NotificationInterface $notificationRepository)
    {
    }
    public function index(): JsonResponse
    {
        $notifications = $this->notificationRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $notifications, Notification::class);
    }
    public function latest(): JsonResponse
     {
         $notifications = $this->notificationRepository->getLatest();
 
         return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $notifications, Notification::class);
     }
    public function getnotifications(User $user): JsonResponse
    {
        $notifications = $this->notificationRepository->getNotifications($user);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $notifications, Notification::class);
    }

    public function updatenotification(UpdateNotificationRequest $request, Notification $notification): JsonResponse
    {
        $notification = $this->notificationRepository->updateNotification($notification, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $notification, Notification::class);
    }
}