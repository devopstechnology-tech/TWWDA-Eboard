<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum PositionEnum: string
{
    use BaseEnumTrait;
    case BoardDirector = 'Board Director';
    case Chairman = 'Chairman';
    case Secretary = 'Secretary';
    case Guest = 'Guest';
    case Owner = 'Owner';
    case Default = 'Member';
}