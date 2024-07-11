<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Committe\Committee;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommitteeUpdateNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $user;
    protected $committee;
    protected $updateMessage;

    public function __construct(User $user, Committee $committee, $updateMessage)
    {
        $this->user = $user;
        $this->committee = $committee;
        $this->updateMessage = $updateMessage;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Committee Update: ' . $this->committee->name)
            ->greeting('Hello! ' . $this->user->full_name)
            ->line($this->updateMessage)
            ->action('View Committee', url(
                config('app.url') . '/board/'.$this->committee->committeeable_id . '/committee/' . $this->committee->id)
            )
            ->line('Thank you for being a valued member!');
    }

    public function toArray($notifiable)
    {
        return [
            'both'       => false,
            'board_id' => $this->committee->committeeable_id ,
            'committee_id' => $this->committee->id,
            'message' => $this->updateMessage
        ];
    }
}

