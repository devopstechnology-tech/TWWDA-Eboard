<?php

declare(strict_types=1);

return [
    'sms' => env('SMS_SERVICE', 'MobiTech'),
    'config' => [
        'at' => [
            'username' => env('AT_USER_NAME'),
            'api_key' => env('AT_API_KEY'),
            'reference' => env('AT_REFERENCE'),
        ],
        'advanta' => [
            'api_key' => env('ADVANTA_API_KEY'),
            'partner_id' => env('ADVANTA_PARTNER_ID'),
            'short_code' => env('ADVANTA_SHORTCODE'),
        ],
        'mobitech' => [
            'api_key' => env('MOBITECH_API_KEY'),
            'username' => env('MOBITECH_USER_NAME'),
            'sender_id' => env('MOBITECH_SENDER_ID'),
        ],
    ],
];
