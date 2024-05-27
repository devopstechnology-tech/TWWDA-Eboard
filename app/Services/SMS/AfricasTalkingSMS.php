<?php

declare(strict_types=1);

namespace App\Services\SMS;

use AfricasTalking\SDK\AfricasTalking;
use App\Services\Contracts\SmsInterface;

class AfricasTalkingSMS implements SmsInterface
{
    public function send(string $message, string $phone): void
    {
        $AT = new AfricasTalking(config('sms.config.at.username'), config('sms.config.at.api_key'));
        $sms = $AT->sms();
        try {
            $sms->send([
                'to' => $phone,
                'message' => $message,
                'from' => config('sms.config.at.reference'),
            ]);
        } catch (\Exception $exception) {
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
