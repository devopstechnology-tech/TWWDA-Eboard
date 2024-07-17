<?php

namespace App\Models\Module\Discussions\Sub;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Discussions\Discussion;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;

class Chat extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'discussion_id',
        'assignee_sender_id',
        'assignee_receiver_id',
        'message',
        'editstatus',
        'file',
    ];
    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_id');
    }

    public function sender()
    {
        return $this->belongsTo(DiscussionAssignee::class, 'assignee_sender_id')
                    ->with('user', 'assignable');
    }

    public function receiver()
    {
        return $this->belongsTo(DiscussionAssignee::class, 'assignee_receiver_id')
                    ->with('user', 'assignable');
    }
}


