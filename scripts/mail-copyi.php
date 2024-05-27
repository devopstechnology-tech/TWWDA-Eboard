<?php

declare(strict_types=1);


$setting = App\Models\Config\Setting::first();
$mailConfig = $setting ? json_decode($setting->mailtype, true) : null;

if ($mailConfig) {
    $values = collect($mailConfig['values'])->pluck('valueName', 'nameField')->toArray();
} else {
    $values = [];
    // Optionally log or handle the missing configuration case
    // Log::error('Mail configuration not found in the database.');
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => $mailConfig['name'] ?? 'smtp',

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array", "failover"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => $values['MAIL_HOST'] ?? null,
            'port' => $values['MAIL_PORT'] ?? null,
            'encryption' => $values['MAIL_ENCRYPTION'] ?? null,
            'username' => $values['MAIL_USERNAME'] ?? null,
            'password' => $values['MAIL_PASSWORD'] ?? null,
            'timeout' => null,
            'auth_mode' => null,
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            'domain' => $values['MAILGUN_DOMAIN'] ?? null,
            'secret' => $values['MAILGUN_SECRET'] ?? null,
            'endpoint' => 'api.mailgun.net',
        ],

        'ses' => [
            'transport' => 'ses',
            'key' => $values['SES_KEY'] ?? null,
            'secret' => $values['SES_SECRET'] ?? null,
            'region' => $values['SES_REGION'] ?? 'us-east-1',
        ],

        'postmark' => [
            'transport' => 'postmark',
            'token' => $values['POSTMARK_TOKEN'] ?? null,
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'log' => [
            'transport' => 'log',
            'channel' => 'mail',
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => [
            'default'  => $values['MAIL_FROM_ADDRESS'] ?? null,
        ],
        'name' => [
            'default' => $values['MAIL_FROM_NAME'] ?? null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
