<?php

namespace App\Notifications;


use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Attendance;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AttendanceReminderNotification extends Notification implements ShouldQueue // Implement the interface here
{
    use Queueable;

    protected $user;
    protected $attendance;
    protected $updateMessage;

    public function __construct(User $user, Attendance $attendance, $updateMessage)
    {
        $this->user = $user;
        $this->attendance = $attendance;
        $this->updateMessage = $updateMessage;
        // $schedule = $this->attendance->schedule;
        // $meeting = $schedule->meeting;
        // $board  = $meeting->meetingable_id;
        // dd($board);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $schedule = $this->attendance->schedule;
        $meeting = $schedule->meeting;
        $board  = $meeting->meetingable_id;
        // dd($board);
        return (new MailMessage)
            ->subject('Reminder: Sign Attendance for Meeting ' . $meeting->title)
            ->greeting('Hello ' . $this->user->full_name . '!')
            ->line($this->updateMessage)
            ->action('Sign Attendance', url(config('app.url') . '/board/' . $board . '/meeting/' . $meeting->id . '/schedule/' . $schedule->id));
    }

    public function toArray($notifiable)
    {
        return [
            'user_id'    => $this->user->id,
            'attendance_id' => $this->attendance->id,
            'message'    => $this->updateMessage,
        ];
    }
}
