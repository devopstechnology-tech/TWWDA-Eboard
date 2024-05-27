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
    ];
    protected $hidden = [
        'tempUserIds',
        'tempMemberUpdates'
    ];   // Ensure it doesn't appear in model's array/json output

    private $tempUserIds = [];
    public $tempMemberUpdates = [];

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

    public function meetings()
    {
        return $this->morphMany(Meeting::class, 'meetingable');
    }

    // Define the relationship to Committee
    // public function committees()
    // {
    //     return $this->hasMany(Committee::class);
    // }

    public function members()
    {
        return $this->morphMany(Member::class, 'memberable');
    }
    public function folders()
    {
        return $this->morphMany(Folder::class, 'folderable');
    }
}
