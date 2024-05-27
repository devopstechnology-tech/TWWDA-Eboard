<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum SeverityEnum: string
{
    use BaseEnumTrait;
    case Green = 'green';
    case Amber = 'amber';
    case Red = 'red';
}