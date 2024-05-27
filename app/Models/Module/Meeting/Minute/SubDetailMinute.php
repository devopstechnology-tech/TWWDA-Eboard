<?php

declare(strict_types=1);

namespace App\Models\Module\Meeting\Minute;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubDetailMinute extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'detail_minute_id',
        'subagenda_id',
        'description',
        'status',
    ];

    public function detailminute()
    {
        return $this->belongsTo(DetailMinute::class, 'detail_minute_id');
    }
    public function subagenda()
    {
        return $this->belongsTo(SubAgenda::class, 'subagenda_id');
    }
}
