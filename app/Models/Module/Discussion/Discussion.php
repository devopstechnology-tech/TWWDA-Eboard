<?php

namespace App\Models\Module\Discussion;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Discussion\Sub\Chat;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Module\Discussion\Sub\DiscussionAssignee;

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
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignees()
    {
        return $this->hasMany(DiscussionAssignee::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
