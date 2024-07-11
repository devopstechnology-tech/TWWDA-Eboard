<?php

declare(strict_types=1);

namespace App\Models\Module\Member;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Poll\Poll;
use App\Models\Module\Task\Task;
use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Position;
use App\Models\Module\Conflict\Conflict;
use App\Models\Module\Poll\AssigneePoll;
use App\Models\Module\Task\Sub\AssigneeTask;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'location',
        'meeting_id',
        'member_id',
        'signature',
        'status',
        'user_id',
        'position_id;',
        'memberable_id',
        'memberable_type',
    ];

    // protected $appends = [
    //     'tempUserIds',
    // ];
    // protected $hidden = [
    //     'tempUserIds',
    // ];   // Ensure it doesn't appear in model's array/json output

    // private $tempUserIds = [];

    // public function setTempUserIdsAttribute($value)
    // {
    //     $this->tempUserIds = $value;
    // }

    // public function getTempUserIdsAttribute()
    // {
    //     return $this->tempUserIds;
    // }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class)
            ->with('profile');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function memberships()
    {
        return $this->hasMany(Conflict::class, 'membership_id');
    }

    public function memberable()
    {
        return $this->morphTo();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'membership_id');
    }
    public function assignees()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_assignees');
    }
    public function assigneeTasks()
    {
        return $this->morphMany(AssigneeTask::class, 'assignable');
    }
    public function assigneePolls()
    {
        return $this->morphMany(AssigneePoll::class, 'assignable');
    }
    public function taskassignees()
    {
        return $this->belongsToMany(Task::class, 'assignee_tasks');
    }
    public function polls()
    {
        return $this->belongsToMany(Poll::class, 'votes');
    }
}