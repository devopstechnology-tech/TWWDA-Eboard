<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogJobProcessed
{
    public function handle(JobProcessed $event)
    {
        Log::info("Job processed successfully: " . $event->job->getName());
    }
}