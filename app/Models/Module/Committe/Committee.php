<?php

declare(strict_types=1);

namespace App\Models\Module\Committe;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\General\Folder;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;
use App\Models\Module\Meeting\Meeting;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Committee extends BaseModel
{
    use Uuids;
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        // 'board_id',
        'icon',
        'cover',
    ];

    public function folder()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }

    public function folders()
    {
        return $this->morphMany(Folder::class, 'folderable');
    }
    public function meetings()
    {
        return $this->morphMany(Meeting::class, 'meetingable');
    }

    // Define the relationship to Board

    public function members()
    {
        return $this->morphMany(Member::class, 'memberable');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
}
