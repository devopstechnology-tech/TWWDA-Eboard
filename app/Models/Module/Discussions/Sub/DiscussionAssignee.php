<?php

namespace App\Models\Module\Discussions\Sub;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Discussions\Discussion;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscussionAssignee extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'discussion_id',
        'user_id',
        'assignable_id',
        'assignable_type',
    ];
    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_id');
    }
    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}