<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Types;

class Permission extends BaseModel
{
    use Types;

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'guard_name',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return $this->type.' '.$this->name;
    }
}
