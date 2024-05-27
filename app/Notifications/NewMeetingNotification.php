<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewMeetingNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $board;
    protected $meeting;
    protected $isUpdate;

    public function __construct(Board $board, Meeting $meeting, $isUpdate = false)
    {
        $this->board = $board;
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
            'board_id' => $this->board->id,
            'meeting_id' => $this->meeting->id,
            'message' => $message
        ];
    }

    public function toMail($notifiable)
    {
        $subject = $this->isUpdate ? "Meeting Updated" : "New Meeting Scheduled";
        return (new MailMessage)
            ->subject($subject)
            ->line($subject . ": {$this->meeting->title}")
            ->action(
                'View Meeting',
                url(
                    // http://revboard.test/board/9c008f46-ff0a-4d37-9694-aae67d4bbf06/meeting/9c00c2ed-6476-4f2d-a415-19c9fc5f89b6
                    config('app.url') . '/board/' . $this->board->id . '/meeting/' . $this->meeting->id
                )
            );
    }
}