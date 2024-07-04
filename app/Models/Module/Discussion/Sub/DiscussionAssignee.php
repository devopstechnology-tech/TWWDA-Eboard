<?php

namespace App\Models\Module\Discussion\Sub;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Discussion\Discussion;
use App\Models\User;
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
        'assignee_id',
        'assignee_type',
    ];
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
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