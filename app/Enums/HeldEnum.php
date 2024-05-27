<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum HeldEnum: string
{
    use BaseEnumTrait;
    case Default = 'scheduled';
    case Held = 'held';
    case Cancelled = 'cancelled';
    case Postponed = 'postponed';
}
