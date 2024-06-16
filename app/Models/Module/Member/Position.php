<?php

namespace App\Models\Module\Member;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'active',
    ];
}