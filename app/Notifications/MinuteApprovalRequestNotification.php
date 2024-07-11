<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Meeting\Minute;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MinuteApprovalRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $minute;
    protected $meetingable;
    protected $updateMessage;

    public function __construct(User $user, Minute $minute, $meetingable, $updateMessage)
    {
        $this->user = $user;
        $this->minute = $minute;
        $this->meetingable = $meetingable;
        $this->updateMessage = $updateMessage;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $schedule = $this->minute->schedule;
        $meeting = $schedule->meeting;
        $meetingTitle = $meeting->title;
        
        // Determine the type and URL path
        $type = $this->meetingable instanceof \App\Models\Module\Board\Board ? 'board' : 'committee';
        $url = config('app.url') . "/{$type}/{$this->meetingable->id}/meeting/{$meeting->id}/schedule/{$schedule->id}/minutes/{$this->minute->id}";

        return (new MailMessage)
            ->subject('Minute Approval Request: ' . $meetingTitle)
            ->greeting('Hello! ' . $this->user->full_name)
            ->line($this->updateMessage)
            ->action('View ' . ucfirst($type), url($url))
            ->line('Thank you for being a valued member!');
    }

    public function toArray($notifiable)
    {
        return [
            'meetingable_type' => get_class($this->meetingable),
            'meetingable_id' => $this->meetingable->id,
            'meeting_id' => $this->minute->id,
            'message' => $this->updateMessage
        ];
    }
}
