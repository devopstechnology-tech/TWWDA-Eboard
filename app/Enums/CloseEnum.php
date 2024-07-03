<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum CloseEnum: string
{
    use BaseEnumTrait;
    case Closed = 'closed';
    case Default = 'opened';
}