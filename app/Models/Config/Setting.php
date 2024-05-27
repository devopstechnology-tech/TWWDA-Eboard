<?php

namespace App\Models\Config;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends BaseModel
{
    use Uuids;
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'logo',
        'textlogo',
        'name',
        'about',
        'website',
        'iso',
        'isologo',
        'address',
        'county',
        'city',
        'state',
        'phone1',
        'phone2',
        'mailer',
        'mailhost',
        'mailport',
        'mailusername',
        'mailpassword',
        'mailencryption',
        'mailfromaddress',
        'mailfromname',
        'pspdkitlicencekey',
        'mailtype',
        'mailtypes',
    ];
    protected $casts = [
        'mailtype' => 'array',  // This will automatically JSON encode/decode the 'mailtype' field
        'mailtypes' => 'array',  // This will automatically JSON encode/decode the 'mailtype' field
    ];
}