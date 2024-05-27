<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Channels\SmsMessage;
use App\Models\Users\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $id_number;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Staff $staff, public string $password)
    {
        $this->id_number = $this->staff->id_number;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage())
            ->subject('🎉 Welcome to ERev  🎉')
            ->from('info@erev.com', 'EREV System')
            ->line('You have been added as revenue collection officer.')
            ->line("Use your $this->id_number and  password: $this->password to login to the app terminal")
            ->line('ERev: Safe, Simple , Convenient');
    }

    public function toSms(object $notifiable): SmsMessage
    {
        return (new SmsMessage())
            ->to($this->staff->phone)
            ->line('Welcome to ERev System')
            ->line('You have been added as revenue collection officer.')
            ->line("Use your $this->id_number and  password: $this->password to login to the app terminal")
            ->line('ERev: Safe, Simple , Convenient');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
