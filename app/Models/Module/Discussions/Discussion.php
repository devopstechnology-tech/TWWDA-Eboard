<?php

namespace App\Models\Module\Discussions;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Discussions\Sub\Chat;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;

class Discussion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'topic',
        'description',
        'closestatus',
        'archivestatus',
        'user_id',
        'dassignees',
    ];
    protected $casts = [
        'dassignees' => 'array',
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id')
                    ->with(
                        'profile',
                        'membership');
    }

    public function assignees()
    {
        return $this->hasMany(DiscussionAssignee::class, 'discussion_id')
                    ->with('assignable', 'user');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class)
                    ->with('sender','receiver');
    }
}
