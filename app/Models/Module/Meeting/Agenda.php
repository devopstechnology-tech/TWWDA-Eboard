<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agenda extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title',
        'description',
        'duration',
        'schedule_id',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
    public function children()
    {
        return $this->hasMany(SubAgenda::class, 'agenda_id')->orderBy('created_at', 'asc');
    }
    public function assignees()
    {
        return $this->belongsToMany(Membership::class, 'agenda_assignees');
    }

    public function minutes()
    {
        return $this->belongsToMany(Minute::class, 'detail_minutes');
    }
}
