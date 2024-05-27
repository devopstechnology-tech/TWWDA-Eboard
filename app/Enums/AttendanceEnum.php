<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum  AttendanceEnum: string
{
    use BaseEnumTrait;
    case Attended = 'Attended';
    case Default = 'Absent';
}
