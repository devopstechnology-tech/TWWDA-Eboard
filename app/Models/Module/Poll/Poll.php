<?php

declare(strict_types=1);

namespace App\Models\Module\Poll;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Board\Board;
use App\Models\Module\Poll\Sub\Vote;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Poll\Sub\Option;
use App\Models\Module\Member\Membership;
use App\Models\Module\Committe\Committee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'question',
        'description',
        'duedate',
        'questionoptiontype',
        'optionstatus',
        'assigneetype',
        'assigneestatus',
        'meeting_id',
        'board_id',
        'committee_id',
        'status',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class, 'committee_id');
    }
    public function options()
    {
        return $this->hasMany(Option::class, 'poll_id');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class, 'poll_id');
    }

    public function memberships()
    {
        return $this->belongsToMany(Membership::class, 'votes');
    }
    public function pollassignees()
    {
        return $this->belongsToMany(Membership::class, 'assignee_polls')
            ->withPivot('id', 'membership_id', 'poll_id') // Include all necessary pivot fields
            ->withTimestamps(); // If timestamps are important
    }
}
