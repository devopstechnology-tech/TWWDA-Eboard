<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum PublishEnum: string
{
    use BaseEnumTrait;
    case Default = 'unpublished';
    case Published = 'published';
}