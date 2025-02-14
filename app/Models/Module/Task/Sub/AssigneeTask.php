<?php

declare(strict_types=1);

namespace App\Models\Module\Task\Sub;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Task\Task;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssigneeTask extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'task_id',
        'assignable_id',
        'assignable_type',
        'status',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function assignable()
    {
        return $this->morphTo();
    }
}
