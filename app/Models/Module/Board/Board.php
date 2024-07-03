<?php

declare(strict_types=1);

namespace App\Models\Module\Board;

use App\Models\User;;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\General\Folder;
use App\Models\Module\Member\Member;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Committe\Committee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Module\Discussion\Sub\DiscussionAssignee;

class Board extends BaseModel
{
    use Uuids;
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'icon',
        'cover',
    ];

    // updating board only but wnato notify already members, 
    //so we store members id to fetch later in observer
    /////protected $appends = ['tempUserIds'];  // Non-persistent attribute
    protected $appends = [
        'tempUserIds',
        'tempMemberUpdates',
        'tempMemberId', //for position update on board/commitie member
        'tempMemberPosition', //for rol update on board/commitie member
    ];
    protected $hidden = [
        'tempUserIds',
        'tempMemberUpdates',
        'tempMemberId',
        'tempMemberPosition',
    ];   // Ensure it doesn't appear in model's array/json output

    private $tempUserIds = [];

    public $tempMemberUpdates = [];

    private $tempMemberId = '';

    public $tempMemberPosition = '';

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

    public function settempMemberIdAttribute($value)
    {
        $this->tempMemberId = $value;
    }


    public function gettempMemberIdAttribute()
    {
        return $this->tempMemberId;
    }
    //observer item
    //for use in observer since we cant access request data in observer 
    //this from request array 
    public function settempMemberPositionAttribute($value)
    {
        $this->tempMemberPosition = $value;
    }

    public function gettempMemberPositionAttribute()
    {
        return $this->tempMemberPosition;
    }


    ////////observer item

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function meetings()
    {
        return $this->morphMany(Meeting::class, 'meetingable');
    }

    public function committees()
    {
        return $this->morphMany(Committee::class, 'committeeable');
    }

    public function members()
    {
        return $this->morphMany(Member::class, 'memberable');
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