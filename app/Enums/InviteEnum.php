<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum InviteEnum: string
{
    use BaseEnumTrait;
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Default  = 'invited'; // Default status until user updates
    //accept reject  invited
}
