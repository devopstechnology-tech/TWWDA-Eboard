<?php

namespace App\Models\Location;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcounty extends BaseModel
{
    use HasFactory;
    protected $table = 'subcounties';
}
