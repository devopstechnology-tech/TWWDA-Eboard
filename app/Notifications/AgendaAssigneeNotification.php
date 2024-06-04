<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Meeting\Agenda;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AgendaAssigneeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $agenda;

    public function __construct(User $user, Agenda $agenda)
    {
        $this->user = $user;
        $this->agenda = $agenda;

        // dd($user, $board);/
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->user->full_name} you have neen allocated this: {$this->agenda->title} agenda.",
            'agenda_id' => $this->agenda->id,
            'both'       => false,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line("{$this->user->full_name} you have neen allocated this: {$this->agenda->title} agenda.")
            ->action('View Agenda', url(config('app.url')));
    }
}