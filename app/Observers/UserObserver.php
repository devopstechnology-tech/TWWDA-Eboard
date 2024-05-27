<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\EmailInviteJob;
use App\Mail\EmailInvite;
use App\Models\System\Otp;
use App\Models\System\PasswordHistory;
use App\Models\User;
use App\Notifications\NewIpDetectedNotification;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    public function created(User $user): void
    {
        if (app()->environment() !== 'testing') {
            $otp = Otp::create([
                'otp' => generateRandomIntString(6),
                'token' => generateRandomString(25),
                'expires_at' => now('Africa/Nairobi')->addMinutes(3000),
                'otpable_id' => $user->id,
                'otpable_type' => User::class
            ]);
            $email = $user->email;
            $fullUrl = config('app.url');
            $mailData = [
                'link' => $fullUrl . "/accept-invitation?token={$otp->token}",
                'message' => 'You are invited to join our platform.'
            ];

            // dispatch(new EmailInviteJob($email, $mailData));
            // $emailInstance = new EmailInvite($mailData);
            // Mail::to($email)->send($emailInstance);
        }
    }

    private function generatePasswordHistory($user): void
    {
        $passwordHistory = PasswordHistory::create([
            'password' => $user->password,
            'start_date' => now('Africa/Nairobi'),
            'change_reason' => 'new',
            'end_date' => now('Africa/Nairobi')->addMonths(3),
        ]);
        $user->passwordHistories()->save($passwordHistory);
    }

    public function updating(User $user): void
    {

        // if ($user->isDirty('last_login_ip')) {
        //     $old_ip = $user->getOriginal('last_login_ip');
        //     // if (app()->environment() !== 'local' || app()->environment() !== 'testing') {
        //     //     if ($user->last_login_ip !== $old_ip) {
        //     //         $user->notify(new NewIpDetectedNotification($user->last_login_ip));
        //     //     }
        //     // }
        // }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}