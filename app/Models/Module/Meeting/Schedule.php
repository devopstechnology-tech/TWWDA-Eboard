<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;
    protected $fillable = [
        'status',
        'heldstatus',
        'date',
        'start_time',
        'end_time',
        'meeting_id',
    ];
    protected $dates = ['deleted_at'];
}