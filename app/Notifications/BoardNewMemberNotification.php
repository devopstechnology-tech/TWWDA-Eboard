<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Module\Board\Board;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User; // Assuming you have a User model

class BoardNewMemberNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $user;
    protected $board;

    public function __construct(User $user, Board $board)
    {
        $this->user = $user;
        $this->board = $board;

        // dd($user, $board);/
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->user->full_name} has joined the board.",
            'board_id' => $this->board->id,
            'both'       => false,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line("{$this->user->full_name}, welcome to our board '{$this->board->name},  feel welcomed.")
            ->action('View Board', url(config('app.url') . '/board/' . $this->board->id));
    }
}
