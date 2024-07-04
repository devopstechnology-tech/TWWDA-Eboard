<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Membership;
use App\Models\Module\Committe\Committee;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Meeting\Minute\DetailMinute;
use App\Models\Module\Meeting\Minute\MinuteReview;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Minute extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'schedule_id',
        'board_id',
        'committee_id',
        'membership_id',
        'status',
        'approvalstatus',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')
            ->with('meeting', 'attendances');
    }
    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
    public function committee()
    {
        return $this->belongsTo(Committee::class, 'committee_id');
    }
    public function author() //minute author
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function detailminutes(): HasMany
    {
        return $this->hasMany(DetailMinute::class, 'minute_id')
            ->with('subdetailminutes')
            ->orderBy('created_at', 'asc');
    }
    public function minuteReviews()
    {
        return $this->hasMany(MinuteReview::class, 'minute_id')->orderBy('created_at', 'asc');
    }
}