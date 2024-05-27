<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting\Minute;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Meeting\Minute;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MinuteReview extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'minute_id',
        'detail_minute_id',
        'membership_id',
        'description',
        'status',
    ];

    public function minute()
    {
        return $this->belongsTo(Minute::class, 'minute_id');
    }
    public function detail_minute()
    {
        return $this->belongsTo(DetailMinute::class, 'detail_minute_id');
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
