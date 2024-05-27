<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public string $email, public string $subject, public string $message)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw($this->message, function ($message) {
            $message->subject($this->subject)
                ->from('noreply@eboard.com', 'E-Board System')
                ->to($this->email);
        });
    }
}
