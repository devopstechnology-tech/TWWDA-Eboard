<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Board\Board;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BoardMemberPositionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $board;
    protected $position;

    public function __construct(User $user, Board $board, string $tempMemberPosition)
    {
        $this->user = $user;
        $this->board = $board;
        $this->position = $tempMemberPosition;

        // dd($user, $board);/
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Hi {$this->user->full_name}, your p in this {$this->board->name} (board) has Been Updaqte.",
            'board_id' => $this->board->id,
            'both'       => false,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line("Your position in this {$this->board->name} (board) has Been Updated.")
            ->action('View Board', url(config('app.url') . '/board/' . $this->board->id));
    }
}