<?php

namespace App\Models\Location;

use App\Models\BaseModel;
use App\Models\Location\Subcounty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends BaseModel
{
    use HasFactory;
    protected $table = 'counties';

    // public function members(): HasMany
    // {
    //     return $this->hasMany(User::class);
    // }

    public function constituencies(): HasMany
    {
        return $this->hasMany(Subcounty::class);
    }
}
