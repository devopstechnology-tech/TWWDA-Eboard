<?php

declare(strict_types=1);

namespace App\Services\SMS;

use App\Services\Contracts\SmsInterface;
use GuzzleHttp\Client;

class AdvantaSMS implements SmsInterface
{
    public function send(string $message, string $phone): void
    {
        $phone = '0'.substr($phone, -9);
        try {
            $client = new Client();
            $client->post('https://quicksms.advantasms.com/api/services/sendsms/', [
                'json' => [
                    'apikey' => config('sms.config.advanta.api_key'),
                    'partnerID' => config('sms.config.advanta.partner_id'),
                    'message' => $message,
                    'shortcode' => config('sms.config.advanta.short_code'),
                    'mobile' => $phone,
                ],
            ]);
        } catch (\Throwable $err) {

        }
    }

    public function getResponseData()
    {
        // TODO: Implement getResponseData() method.
    }

    public function sendBulk(string $message, array $phones)
    {
        // TODO: Implement sendBulk() method.
    }
}
