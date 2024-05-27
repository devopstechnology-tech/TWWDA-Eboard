<?php

namespace App\Models\Users;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends BaseModel
{
    use HasFactory;
    use Uuids;
    protected $fillable = [
        'name'
    ];
}
