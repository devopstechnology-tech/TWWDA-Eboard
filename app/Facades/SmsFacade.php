<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\Contracts\SmsInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static send(string $text, string $phone)
 * @method static sendBulk(string $text, array $phones)
 * @method static getResponseData()
 */
class SmsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SmsInterface::class;
    }
}
