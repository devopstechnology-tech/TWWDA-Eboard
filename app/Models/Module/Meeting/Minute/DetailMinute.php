<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting\Minute;

use App\Traits\Uuids;
use App\Models\BaseModel;
use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Minute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailMinute extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'minute_id',
        'agenda_id',
        'description',
        'status',
    ];

    public function minute()
    {
        return $this->belongsTo(Minute::class, 'minute_id');
    }
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
    public function subagenda()
    {
        return $this->belongsTo(SubAgenda::class, 'subagenda_id');
    }
    public function subdetailminute()
    {
        return $this->hasOne(SubDetailMinute::class, 'detail_minute_id');
    }
    public function minutereview()
    {
        return $this->hasOne(MinuteReview::class, 'detail_minute_id');
    }
}
