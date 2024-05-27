<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\EmailJob;
use App\Jobs\SMSJob;
use App\Models\Users\Staff;
use App\Notifications\StaffCreatedNotification;

class StaffObserver
{
    /**
     * Handle the Staff "created" event.
     */
    public function created(Staff $staff): void
    {
        if (app()->environment() !== 'testing') {
            $password = generateRandomString(8);
            $staff->access_key = generateRandomString(20);
            $staff->serial_no = addUp(
                Staff::max('serial_no') != null ?
                    Staff::max('serial_no') :
                    generateRandomString(9)
            );
            $staff->access_secret = generateRandomString(9);
            $staff->password = $password;
            $staff->save();
            // $staff->notify(new StaffCreatedNotification($staff->refresh(), $password));
        }
    }

    /**
     * Handle the Staff "updated".
     */
    public function updated(Staff $staff): void
    {
        //
    }

    /**
     * Handle the Staff "deleted" event.
     */
    public function deleted(Staff $staff): void
    {
        $message = 'Welcome to ERev Payment System' . PHP_EOL;
        $message .= 'You have been terminated as revenue collection officer' . PHP_EOL;
        $message .= 'If this was a mistake contact your supervisor' . PHP_EOL;
        $message .= 'ERev: Safe, Simple , Convenient' . PHP_EOL;
        dispatch(new SmsJob($message, $staff->phone));
        dispatch(new EmailJob($staff->email, '😔 Welcome to ERev', $message));
    }

    /**
     * Handle the Staff "restored" event.
     */
    public function restored(Staff $staff): void
    {
        $message = 'Welcome to ERev Payment System' . PHP_EOL;
        $message .= 'Your account has been restored as a revenue collection officer' . PHP_EOL;
        $message .= 'ERev: Safe, Simple , Convenient' . PHP_EOL;
        dispatch(new SmsJob($message, $staff->phone));
        dispatch(new EmailJob($staff->email, '🥳 Welcome to ERev', $message));
    }

    /**
     * Handle the Staff "force deleted" event.
     */
    public function forceDeleted(Staff $staff): void
    {
        //
    }
}