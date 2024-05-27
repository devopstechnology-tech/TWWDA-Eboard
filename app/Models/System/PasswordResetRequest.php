<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PasswordResetRequest extends BaseModel
{
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }
}
