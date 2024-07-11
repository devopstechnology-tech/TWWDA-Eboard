<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Committe\Committee;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommitteeNewMemberNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $user;
    protected $committee;

    public function __construct(User $user, Committee $committee)
    {
        $this->user = $user;
        $this->committee = $committee;

        // dd($user, $committee);/
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->user->full_name} has joined the committee.",
            'committee_id' => $this->committee->id,
            'both'       => false,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line("{$this->user->full_name}, welcome to our committee '{$this->committee->name},  feel welcomed.")
            ->action('View Committee', url(
                config('app.url') . '/board/'.$this->committee->committeeable_id . '/committee/' . $this->committee->id)
            );
    }
}


