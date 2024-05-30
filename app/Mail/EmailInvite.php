<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailInvite extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        return $this->from(config('mail.from.address.default'), 'EBoard Pro Platform')
            ->subject('Your Invitation to Join')
            ->view('emails.invite', ['mailData' => $this->mailData]); // Ensure you use view if using HTML templates
    }
}
