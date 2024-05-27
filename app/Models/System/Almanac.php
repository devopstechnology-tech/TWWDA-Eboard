<?php

namespace App\Models\System;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almanac extends BaseModel
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'type',
        'purpose',
        'start',
        'end',
        'budget',
        'status',
        'held',
    ];
    protected $dates = ['start', 'end'];
}
