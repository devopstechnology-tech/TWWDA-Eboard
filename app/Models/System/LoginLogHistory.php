<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LoginLogHistory extends BaseModel
{
    use Uuids;
    public function login_loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
