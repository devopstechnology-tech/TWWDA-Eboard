<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum VoteEnum: string
{
    use BaseEnumTrait;
    case Voted = 'voted';
    case Default = 'pending';
    case OnProgress = 'onprogress';
}