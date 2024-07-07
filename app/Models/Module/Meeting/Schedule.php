<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Attendance;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;
    protected $fillable = [
        'status',
        'closestatus',
        'heldstatus',
        'date',
        'start_time',
        'end_time',
        'meeting_id',
    ];
    protected $dates = ['deleted_at'];
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'schedule_id')
                    ->with('membership', 'schedule', 'media');
    }
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'schedule_id');
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
