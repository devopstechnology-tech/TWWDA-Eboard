<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewMeetingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $meetingable;
    protected $meeting;
    protected $isUpdate;

    public function __construct($meetingable, Meeting $meeting, $isUpdate = false)
    {
        $this->meetingable = $meetingable;
        $this->meeting = $meeting;
        $this->isUpdate = $isUpdate;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        $message = $this->isUpdate ? "Meeting updated: {$this->meeting->title}" : "New meeting scheduled: {$this->meeting->title}";
        return [
            'meetingable_id' => $this->meetingable->id,
            'meetingable_type' => get_class($this->meetingable),
            'meeting_id' => $this->meeting->id,
            'message' => $message
        ];
    }

    public function toMail($notifiable)
    {
        $subject = $this->isUpdate ? "Meeting Updated" : "New Meeting Scheduled";
        $type = $this->meetingable instanceof Board ? 'board' : 'committee';
        return (new MailMessage)
            ->subject($subject)
            ->line($subject . ": {$this->meeting->title}")
            ->action(
                'View Meeting',
                url(
                    config('app.url') . '/' . $type . '/' . $this->meetingable->id . '/meeting/' . $this->meeting->id
                )
            );
    }
}
