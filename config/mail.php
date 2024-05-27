<?php


declare(strict_types=1);
// config/mail.php

return [
    'default' => 'smtp',  // Placeholder value

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => 'placeholder',  // Placeholder value
            'port' => 2525,
            'encryption' => 'tls',
            'username' => 'placeholder',
            'password' => 'placeholder',
            'timeout' => null,
            'auth_mode' => null,
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            'domain' => 'placeholder',
            'secret' => 'placeholder',
            'endpoint' => 'api.mailgun.net',
        ],

        'ses' => [
            'transport' => 'ses',
            'key' => 'placeholder',
            'secret' => 'placeholder',
            'region' => 'us-east-1',
        ],

        'postmark' => [
            'transport' => 'postmark',
            'token' => 'placeholder',
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

    'from' => [
        'address' => 'placeholder',  // Placeholder value
        'name' => 'placeholder',
    ],

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];
