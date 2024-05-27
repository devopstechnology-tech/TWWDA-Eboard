<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum ChangePasswordEnum: string
{
    use BaseEnumTrait;
    case New = 'new';
    case Forgot = 'forgot';
    case VoluntaryChange = 'voluntary_change';
    case Expired = 'expired';
}