<?php

namespace App\Models\Module\Task\Sub;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Task\Sub\AssigneeTask;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Taskstatus extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'task_id',
        'assignee_task_id',
        'date',
        'status',
    ];
    public function assignee()
    {
        return $this->belongsTo(AssigneeTask::class, 'assignee_task_id');
    }
}
