<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum NetworkProvidersEnum: string
{
    use BaseEnumTrait;
    case Safaricom = 'safaricom';
    case Airtel = 'airtel';
    case Telkom = 'telkom';
    case Faiba = 'faiba';
}