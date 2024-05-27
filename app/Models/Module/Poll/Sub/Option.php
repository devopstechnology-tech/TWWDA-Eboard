<?php

declare(strict_types=1);

namespace App\Models\Module\Poll\Sub;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Poll\Poll;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title',
        'poll_id',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'Poll_id');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class, 'option_id');
    }
}
