<?php

declare(strict_types=1);

namespace App\Models\Module\Member;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Position;
use App\Models\Module\Poll\AssigneePoll;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;
use App\Models\Module\Task\Sub\AssigneeTask;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'memberable_id',
        'memberable_type',
        'board_id',
        'committee_id',
        'guest_id',
        'position_id',
        'user_id',
    ];

    public function memberable()
    {
        return $this->morphTo()
                    ->with('committee');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
    public function committee()
    {
        return $this->belongsTo(Committee::class, 'committee_id');
    }
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->with('profile');
    }
    public function assigneeTasks()
    {
        return $this->morphMany(AssigneeTask::class, 'assignable');
    }
    public function assigneePolls()
    {
        return $this->morphMany(AssigneePoll::class, 'assignable');
    }
    public function assigneeDiscussions()
    {
        return $this->morphMany(DiscussionAssignee::class, 'assignable');
    }
}