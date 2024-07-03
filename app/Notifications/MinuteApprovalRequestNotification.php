<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Meeting\Minute;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MinuteApprovalRequestNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $user;
    protected $minute;
    protected $updateMessage;

    public function __construct(User $user, Minute $minute, $updateMessage)
    {
        $this->user = $user;
        $this->minute = $minute;
        $this->updateMessage = $updateMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }
    public function toMail($notifiable)
    {

        // Fetch the schedule associated with the minute
        $schedule = $this->minute->schedule;
        // // Access the meeting associated with the schedule
        $meeting = $schedule->meeting;
        $board = $meeting->meetingable_id;
        // Get the meeting title and schedule date
        $meetingTitle = $meeting->title;
        return (new MailMessage)
            ->subject('Minute Approval Request: ' . $meetingTitle)
            ->greeting('Hello! ' . $this->user->full_name)
            ->line($this->updateMessage)
            ->action('View Board', url(config('app.url') . '/board/' . $board . '/meeting/' . $meeting->id . '/schedule/' . $schedule->id . '/minutes/' . $this->minute->id))
            ->line('Thank you for being a valued member!');
    }

    public function toArray($notifiable)
    {
        return [
            'both'       => false,
            'meeting_id' => $this->minute->id,
            'message' => $this->updateMessage
        ];
    }
}