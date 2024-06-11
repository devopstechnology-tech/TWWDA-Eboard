<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum ScheduletypeEnum: string
{
    use BaseEnumTrait;
    case Default     = 'single';
    case Recurring   = 'recurring';
    case Manual      = 'manual';
}