<?php

declare(strict_types=1);

namespace App\Models\Module\Committe;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommitteeMember extends BaseModel
{
    use HasFactory;
    use Uuids;
    protected $fillable = [
        'user_id',
        'group_id'
    ];
}
