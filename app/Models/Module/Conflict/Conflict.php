<?php

namespace App\Models\Module\Conflict;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conflict extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use SoftDeletes;
    use Uuids;
    protected $fillable = [
        'address',
        'nature',
        'amount',
        'ceased_date',
        'remarks',
        'meeting_id',
        'membership_id',
        'signature',
        'status',
    ];

    public function meeting(){
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
    public function membership(){
        return $this->belongsTo(Membership::class, 'membership_id');
    }

}
