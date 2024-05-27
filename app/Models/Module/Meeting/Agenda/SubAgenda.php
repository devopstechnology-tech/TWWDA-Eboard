<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting\Agenda;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Meeting\Minute\SubDetailMinute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubAgenda extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title',
        'description',
        'duration',
        'agenda_id',
    ];

    public function assignees()
    {
        return $this->belongsToMany(Membership::class, 'agenda_assignees', 'subagenda_id');
    }
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
    public function subdetailminute()
    {
        return $this->hasOne(SubDetailMinute::class, 'subagenda_id');
    }
}
