<?php

declare(strict_types=1);

namespace App\Mail;

class PasswordResetRequestMail extends BaseEmail
{
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
        return $this->view('mail.templates.forgot_password_request')
            ->to($this->mailTo)
            ->from(config('mail.from.address.default'), config('mail.from.name.default'))
            ->subject('Reset Password');
    }
}
