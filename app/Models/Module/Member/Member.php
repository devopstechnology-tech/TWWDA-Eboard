<?php

declare(strict_types=1);

namespace App\Models\Module\Member;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Board\Board;
use App\Models\Module\Committe\Committee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'board_id',
        'committee_id',
        'guest_id',
        'position',
        'user_id',
    ];

    public function memberable()
    {
        return $this->morphTo();
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
    public function committee()
    {
        return $this->belongsTo(Committee::class, 'committee_id');
    }
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
