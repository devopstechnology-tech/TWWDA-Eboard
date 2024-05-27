<?php

declare(strict_types=1);

namespace App\Services\SMS;

use App\Services\Contracts\SmsInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MobiTechSMS implements SmsInterface
{
    public function send(string $message, string $phone): void
    {
        try {
            // push exceptions to slack
            $client = new Client();
            $client->post('http://bulksms.mobitechtechnologies.com/api/sendsms', [
                'json' => [
                    'api_key' => config('sms.config.mobitech.api_key'),
                    'username' => config('sms.config.mobitech.username'),
                    'sender_id' => config('sms.config.mobitech.sender_id'),
                    'message' => $message,
                    'phone' => $phone,
                ],
            ]);
        } catch (Exception|GuzzleException $err) {

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
