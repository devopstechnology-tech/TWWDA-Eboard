<?php

declare(strict_types=1);

namespace App\Models\Module\Task;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Task\Sub\Taskstatus;
use App\Models\Module\Task\Sub\AssigneeTask;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title',
        'duedate',
        'description',
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
    public function taskstatuses()
    {
        return $this->hasMany(Taskstatus::class, 'task_id');
    }

    public function taskassignees()
    {
        return $this->hasMany(AssigneeTask::class, 'task_id')
                    ->with('assignable.user');
    }
}
