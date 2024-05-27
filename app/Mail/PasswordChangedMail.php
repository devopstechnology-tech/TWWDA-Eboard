<?php

declare(strict_types=1);

namespace App\Mail;

class PasswordChangedMail extends BaseEmail
{
    public function __construct($data, $to)
    {
        parent::__construct($data, $to);
    }

    public function build(): PasswordChangedMail
    {
        return $this->view('mail.templates.password_changed')
            ->to($this->mailTo)
            ->from(config('mail.from.address.default'), config('mail.from.name.default'))
            ->subject('Password Changed');
    }
}
