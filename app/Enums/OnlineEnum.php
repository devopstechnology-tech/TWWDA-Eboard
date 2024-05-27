<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum OnlineEnum: int
{
    use BaseEnumTrait;
    case Default = 0;
    case Online = 1;
}