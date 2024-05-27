<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum StatusEnum: string
{
    use BaseEnumTrait;
    case Active = 'active';
    case Inactive = 'inactive';
    case Disabled = 'disabled';
    case Valid = 'valid';
    case Invalid = 'invalid';
}