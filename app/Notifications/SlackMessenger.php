<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackMessenger extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $message,
        public string $from,
        public string $channel = 'eboard',
        public ?string $mainTitle = null,
        public string $title = 'New Notification'
    ) {
        $this->mainTitle = $mainTitle ?? $message;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->from('E-Board System')
            ->subject($this->title)
            ->line($this->message)
            ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage())
            ->from($this->from, $this->icon ?? ':ghost')
            ->to($this->channel)
            ->content($this->mainTitle)
            ->attachment(function ($attachment) {
                $attachment->title($this->title)
                    ->content($this->message)
                    ->markdown(['text']);
            });
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['slack'];
    }
}
