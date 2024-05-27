<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting\Minute;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubMinuteReview extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'minute_review_id',
        'sub_detail_minute_id',
        'membership_id',
        'description',
        'status',
    ];

    public function minutereview()
    {
        return $this->belongsTo(MinuteReview::class, 'minute_review_id');
    }
    public function subdetailminute()
    {
        return $this->belongsTo(SubDetailMinute::class, 'sub_detail_minute_id');
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
