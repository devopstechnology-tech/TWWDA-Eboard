<?php

declare(strict_types=1);

namespace App\Models\Module\Member;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];

    public function members()
    {
        return $this->morphMany(Member::class, 'memberable');
    }
}
