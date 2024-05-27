<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum ApprovalEnum: string
{
    use BaseEnumTrait;
    case Approved = 'approved';
    case Default = 'unapproved';
}