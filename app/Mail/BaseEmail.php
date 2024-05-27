<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseEmail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    protected string $mailTo;
    protected mixed $data;

    public function __construct($data, $to)
    {
        $this->mailTo = $to;
        $this->data = $data;
    }
}
