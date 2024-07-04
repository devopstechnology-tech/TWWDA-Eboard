<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum ArchiveEnum: string
{
    use BaseEnumTrait;
    case Archive = 'archived';
    case Default = 'none';
}