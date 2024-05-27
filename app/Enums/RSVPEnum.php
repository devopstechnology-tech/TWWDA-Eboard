<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum RSVPEnum: string
{
    use BaseEnumTrait;
    case Yes = 'Yes';
    case No = 'No';
    case Maybe = 'Maybe';
    case Online = 'Online';
    case Default = 'Pending'; // Default status until user updates
}
