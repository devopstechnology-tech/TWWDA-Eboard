<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class ProfileResource extends BaseResource
{
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            // Base resource fields here
            'id' => $this->resource->getRouteKey(),
            'avatar' => $this->resource->avatar,
            'ethnicity' => $this->resource->ethnicity,
            'phone' => $this->resource->phone,
            'idpassportnumber' => $this->resource->idpassportnumber,
            'gender_id' => $this->resource->gender_id,
            'address' => $this->resource->address,
            'home_county_id' => $this->resource->home_county_id,
            'residence_county_id' => $this->resource->residence_county_id,
            'city' => $this->resource->city,
            'state' => $this->resource->state,
            'nationality' => $this->resource->nationality,
            'about' => $this->resource->about,
            'kra_pin' => $this->resource->kra_pin,
            'member_cv' => $this->resource->member_cv,
            'establishment' => $this->resource->establishment,
            'title' => $this->resource->title,
            'appointing_authority' => $this->resource->appointing_authority,
            'appointnment_date' => $this->resource->appointnment_date,
            'appointment_letter' => $this->resource->appointment_letter,
            'appointment_end_date' => $this->resource->appointment_end_date,
            'serving_term' => $this->resource->serving_term,
            'current_period' => $this->resource->current_period,
            'user_id' => $this->resource->user_id,
            'user' => $this->resource->user,
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            // Short resource fields here
        ];
    }
}