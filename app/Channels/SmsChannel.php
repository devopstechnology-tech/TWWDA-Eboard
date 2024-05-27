<?php

declare(strict_types=1);

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toSms($notifiable);

        $message->send();

        $message->dryRun()->send();
    }
}
