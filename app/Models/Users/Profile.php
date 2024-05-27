<?php

namespace App\Models\Users;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Support\Str;
use App\Models\Location\County;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends BaseModel
{
    use HasFactory;
    use Uuids;
    protected $fillable = [
        'avatar',
        'ethnicity',
        'phone',
        'idpassportnumber',
        'gender_id',
        'address',
        'home_county_id',
        'residence_county_id',
        'city',
        'state',
        'nationality',
        'about',
        'kra_pin',
        'member_cv',
        'establishment',
        'title',
        'appointing_authority',
        'appointnment_date',
        'appointment_letter',
        'appointment_end_date',
        'serving_term',
        'current_period',
        'user_id',
    ];

    public function setAttribute($key, $value): mixed
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function phone(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => formatPhoneNumber($value)
        );
    }

    public function idpassportnumber(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => formatIdNumber($value)
        );
    }
    public function homecounty()
    {
        return $this->belongsTo(County::class, 'home_county_id');
    }
    public function residencecounty()
    {
        return $this->belongsTo(County::class, 'residence_county_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}