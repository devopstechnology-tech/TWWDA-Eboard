<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnumTrait;

enum TypeEnum: string
{
    use BaseEnumTrait;
    case File = 'file';
    case Folder = 'folder';
}