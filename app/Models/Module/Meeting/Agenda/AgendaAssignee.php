<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting\Agenda;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Member\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAssignee extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'agenda_id',
        'subagenda_id',
        'membership_id',
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
    public function subagenda()
    {
        return $this->belongsTo(SubAgenda::class, 'subagenda_id');
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
