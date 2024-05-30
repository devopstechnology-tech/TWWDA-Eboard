<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Channels\SmsMessage;
use App\Models\System\Otp;
use App\Models\User;
use App\Models\Users\Citizen;
use App\Models\Users\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangeRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $message;
    public Otp $otp;

    public function __construct(public User $user)
    {
        $this->otp = $this->user->otp;
        $this->message = "Your Verification OTP is {$this->otp->otp}";
    }

    public function via(object $notifiable): array
    {
        // return ['mail', SmsChannel::class];
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailFromAddress = config('mail.from.address');
        $mailFromName = config('mail.from.name');

        $fullUrl = config('app.url');
        $appName = env('APP_NAME');
        return (new MailMessage())
            ->subject('🗝️ Password Reset OTP')
            ->from($mailFromAddress, $mailFromName)
            ->line("Here is your OTP {$this->otp->otp}")
            ->action('Reset Password', $fullUrl . "/change-password?token={$this->otp->token}")
            ->line('Thank you for using the' .  $appName);
    }

    public function toSms(object $notifiable): SmsMessage
    {
        return (new SmsMessage())
            ->to($this->user->phone)
            ->line($this->message);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
