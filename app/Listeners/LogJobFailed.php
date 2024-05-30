<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobFailed; // Ensure correct namespace
use Illuminate\Support\Facades\Log;

class LogJobFailed
{
    public function handle(JobFailed $event)
    {
        Log::error("Job failed: " . $event->job->getName() . " with error: " . $event->exception->getMessage());
    }
}
