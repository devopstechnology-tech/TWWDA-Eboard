<?php

declare(strict_types=1);

namespace App\Models\Module\Poll\Sub;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Poll\Poll;
use App\Models\Module\Member\Member;
use App\Models\Module\Member\Membership;
use App\Models\Module\Poll\AssigneePoll;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'option_id',
        'poll_id',
        'assginee_poll_id',
        'date',
        'status',
    ];

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }
    public function assignee()
    {
        return $this->belongsTo(AssigneePoll::class, 'assginee_poll_id');
    }
    // public function member()
    // {
    //     return $this->belongsTo(Member::class, 'member_id');
    // }
}
