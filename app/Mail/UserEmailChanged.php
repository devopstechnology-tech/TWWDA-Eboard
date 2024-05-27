<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class UserEmailChanged extends BaseEmail
{
    use Queueable;
    use SerializesModels;

    public $mailData;

    public function __construct($data, $to)
    {
        parent::__construct($data, $to);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.templates.mail_changed')
            ->to($this->mailTo)
            ->from(config('mail.from.address.default'), config('mail.from.name.default'))
            ->subject('📬 Email Changed');
    }
}
