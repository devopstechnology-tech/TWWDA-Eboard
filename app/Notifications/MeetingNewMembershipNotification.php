<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MeetingNewMembershipNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $board;
    protected $meeting;
    protected $isNew;

    public function __construct(Board $board, Meeting $meeting, User $user, $isNew = true)
    {
        $this->board = $board;
        $this->meeting = $meeting;
        $this->isNew = $isNew;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        $message = $this->isNew ? "Welcome to the membership program." : "Your membership details have been updated.";
        return [
            'both'       => true,
            'board_id'   => $this->board->id,
            'meeting_id' => $this->meeting->id,
            'message'    => $message
        ];
    }

    public function toMail($notifiable)
    {
        $subject = $this->isNew ? "Welcome to Our Membership" : "Membership Updated";
        $message = $this->isNew ? "Welcome to the membership program." : "Your membership details have been updated.";
        return (new MailMessage)
            ->subject($subject)
            ->line($message)
            ->action(
                'View Membership',
                url(
                    // http://revboard.test/board/9c008f46-ff0a-4d37-9694-aae67d4bbf06/meeting/9c00c2ed-6476-4f2d-a415-19c9fc5f89b6
                    config('app.url') . '/board/' . $this->board->id . '/meeting/' . $this->meeting->id
                )
            );
    }
}