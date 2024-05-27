<?php

declare(strict_types=1);

namespace App\Facades;

use App\Libs\MpesaLibrary;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin MpesaLibrary
 */
class MpesaFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'mpesa';
    }
}
