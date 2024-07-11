<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Committe\Committee;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommitteeMemberPositionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $committee;
    protected $position;

    public function __construct(User $user, Committee $committee, string $tempMemberPosition)
    {
        $this->user = $user;
        $this->committee = $committee;
        $this->position = $tempMemberPosition;

        // dd($user, $committee);/
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Hi {$this->user->full_name}, your poisition in this {$this->committee->name} (committee) has Been Updaqte.",
            'committee_id' => $this->committee->id,
            'both'       => false,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line("Your position in this {$this->committee->name} (committee) has Been Updated.")
            ->action('View Committee', url(
                config('app.url') . '/board/'.$this->committee->committeeable_id . '/committee/' . $this->committee->id)
            );
    }
}


