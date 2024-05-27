<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PasswordHistory extends BaseModel
{
    use Uuids;
    protected $table = 'password_logs';

    public function password_loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
