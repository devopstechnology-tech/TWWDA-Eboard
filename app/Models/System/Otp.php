<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Otp extends BaseModel
{
    use Uuids;
    protected $casts = [
        'expires_at' => 'date',
        //        'otp' => 'encrypted',
        //        'token' => 'encrypted',
        'otpable_id', 'otpable_type'
    ];
    protected $hidden = [
        'otp',
        'token',
        'pivot',
    ];
    protected $guarded = [];

    public function otpable(): MorphTo
    {
        return $this->morphTo();
    }
}
