<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum TaskEnum: string
{
    use BaseEnumTrait;
    case Backlog = 'backlog';
    case Pending = 'pending';
    case OnProgress = 'onprogress';
    case Completed = 'completed';
}