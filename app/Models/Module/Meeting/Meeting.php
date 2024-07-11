<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\General\Folder;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Attendance;
use App\Models\Module\Member\Membership;
use App\Models\Module\Committe\Committee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Module\Discussion\Sub\DiscussionAssignee;

class Meeting extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title',
        'conference',
        'link',
        'location',
        'status',
        'description',
        'owner_id',
        'meetingable_id',
        'meetingable_type',
    ];

    // updating meeting only but wnato notify already members, 
    //so we store members id to fetch later in observer
    /////protected $appends = ['tempUserIds'];  // Non-persistent attribute
    protected $appends = [
        'isUpdate',
        'tempUserIds',
        'tempMemberUpdates',
    ];
    protected $hidden = [
        'isUpdate',
        'tempUserIds',
        'tempMemberUpdates'
    ];   // Ensure it doesn't appear in model's array/json output

    private $isUpdate = [];
    private $tempUserIds = [];
    private $tempMemberUpdates = [];

    public function setIsUpdateAttribute($value)
    {
        $this->isUpdate = $value;
    }

    public function getIsUpdateAttribute()
    {
        return $this->isUpdate;
    }
    public function setTempUserIdsAttribute($value)
    {
        $this->tempUserIds = $value;
    }

    public function getTempUserIdsAttribute()
    {
        return $this->tempUserIds;
    }
    //observer item
    //for use in observer since we cant access request data in observer 
    //this from request array 
    public function setTempMemberUpdatesAttribute($value)
    {
        $this->tempMemberUpdates = $value;
    }

    public function getTempMemberUpdatesAttribute()
    {
        return $this->tempMemberUpdates;
    }
    ////////observer item



    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function meetingable()
{
    return $this->morphTo();
}

public function board()
{
    if ($this->meetingable_type === Board::class) {
        return $this->meetingable;
    }
    return null;
}

public function committee()
{
    if ($this->meetingable_type === Committee::class) {
        return $this->meetingable;
    }
    return null;
}
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'meeting_id')
            ->with('attendances', 'agendas');
    }


    public function memberships()
    {
        return $this->hasMany(Membership::class, 'meeting_id');
    }

    public function minutes()
    {
        return $this->hasMany(Minute::class, 'meeting_id');
    }
    public function folders()
    {
        return $this->morphMany(Folder::class, 'folderable');
    }
    public function discussionAssignees()
    {
        return $this->morphMany(DiscussionAssignee::class, 'assignees');
    }
}