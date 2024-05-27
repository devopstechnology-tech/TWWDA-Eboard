<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum SignEnum: string
{
    use BaseEnumTrait;
    case Signed = 'signed';
    case Default = 'unsigned';
}