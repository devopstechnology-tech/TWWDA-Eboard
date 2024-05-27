<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\System\LoginLog;

class LoginLogObserver
{
    /**
     * Handle the LoginLog "created" event.
     */
    public function created(LoginLog $loginLog): void
    {
        // check if the model has other
    }

    /**
     * Handle the LoginLog "updated" event.
     */
    public function updated(LoginLog $loginLog): void
    {
        //
    }

    /**
     * Handle the LoginLog "deleted" event.
     */
    public function deleted(LoginLog $loginLog): void
    {
        //
    }

    /**
     * Handle the LoginLog "restored" event.
     */
    public function restored(LoginLog $loginLog): void
    {
        //
    }

    /**
     * Handle the LoginLog "force deleted" event.
     */
    public function forceDeleted(LoginLog $loginLog): void
    {
        //
    }
}
