<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Disapproval extends BaseModel
{
    public function disapprover(): MorphTo
    {
        return $this->morphTo();
    }

    public function modification(): BelongsTo
    {
        return $this->belongsTo(config('approval.models.modification', Modification::class));
    }
}
