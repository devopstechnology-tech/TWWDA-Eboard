<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Board\Board;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BoardUpdateNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $user;
    protected $board;
    protected $updateMessage;

    public function __construct(User $user, Board $board, $updateMessage)
    {
        $this->user = $user;
        $this->board = $board;
        $this->updateMessage = $updateMessage;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Board Update: ' . $this->board->name)
            ->greeting('Hello! ' . $this->user->full_name)
            ->line($this->updateMessage)
            ->action('View Board', url(config('app.url') . '/board/' . $this->board->id))
            ->line('Thank you for being a valued member!');
    }

    public function toArray($notifiable)
    {
        return [
            'both'       => false,
            'board_id' => $this->board->id,
            'message' => $this->updateMessage
        ];
    }
}