<?php

declare(strict_types=1);

namespace App\Models\Module\Member;

use App\Traits\Uuids;
use App\Enums\RSVPEnum;
use App\Models\BaseModel;
use App\Enums\AttendanceEnum;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'location',
        'meeting_id',
        'membership_id',
        'rsvp_status',
        'attendance_status',
    ];
    protected $casts = [
        'rsvp_status' => RSVPEnum::class,
        'attendance_status' => AttendanceEnum::class,
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}