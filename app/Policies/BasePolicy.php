<?php

declare(strict_types=1);

namespace App\Policies;

use App\Traits\UserPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;
    use UserPermission;
}
