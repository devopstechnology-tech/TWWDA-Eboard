<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Stevebauman\Location\Facades\Location;

class NewIpDetectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $ip)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $currentUserInfo = Location::get($this->ip);

        //        $currentUserInfo = Location::get('41.80.119.23');

        $mailFromAddress = config('mail.from.address');
        $mailFromName = config('mail.from.name');
        $res = (new MailMessage())
            ->subject('🖥️ New Device/Network Login Detected')
            ->from( $mailFromAddress, $mailFromName)
            ->line('New login detected')
            ->line("IP: $this->ip");

        if ($currentUserInfo) {
            $res->line("Country: $currentUserInfo?->countryName")
                ->line("City: $currentUserInfo?->cityName");
        }
        $res->line('If this was not you please change your password!')
            ->line('Thank you for using our application!');

        return $res;
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