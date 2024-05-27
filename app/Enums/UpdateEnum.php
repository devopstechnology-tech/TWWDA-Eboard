<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum UpdateEnum: string
{
    use BaseEnumTrait;
    case Updated = 'updated';
    case Default = 'pending';
}