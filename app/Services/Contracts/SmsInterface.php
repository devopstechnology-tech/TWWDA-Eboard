<?php

declare(strict_types=1);

namespace App\Services\Contracts;

/**
 * @method static send(string $text, string $phone)
 * @method static sendBulk(string $text, array $phones)
 * @method  static getResponseData()
 */
interface SmsInterface
{
    public function send(string $message, string $phone);
    public function sendBulk(string $message, array $phones);

    public function getResponseData();
}
