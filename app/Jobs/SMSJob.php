<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Facades\SmsFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SMSJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly string $text, private readonly string $phone)
    {
    }

    public function handle(): void
    {
        SmsFacade::send($this->text, $this->phone);
    }
}
