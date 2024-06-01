<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum PositionEnum: string
{
    use BaseEnumTrait;

    case System           = 'system';
    case Admin            = 'admin';
    case CEO              = 'ceo';
    case CompanyChairman  = 'company chairman';
    case CompanySecretary = 'company secretary';
    case Chairperson      = 'chairperson';
    case Secretary        = 'secretary';
    case Member           = 'member';
    case Guest            = 'guest';
    case Owner            = 'owner';
    case Default          = 'observer';
}
