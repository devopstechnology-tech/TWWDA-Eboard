<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum EditEnum: string
{
    use BaseEnumTrait;
    case Edited = 'edited';
    case Deleted = 'deleted';
    case Default = 'normal';
}
