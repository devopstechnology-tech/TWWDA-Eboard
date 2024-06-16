<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // 'id' => RuleSet::create()->required()->string(),
            'first' => RuleSet::create()->required()->string(),
            'last' => RuleSet::create()->required()->string(),
            'other_names' => RuleSet::create()->nullable()->string(),
            'email' => RuleSet::create()->required()->email()->string(),
            'password' => RuleSet::create()->nullable(),
            'avatar' => RuleSet::create()->sometimes(),
            'ethnicity' => RuleSet::create()->nullable(),
            'phone' => RuleSet::create()->nullable()->numeric()->min(10),
            'id_Passport_number' => RuleSet::create()->nullable()->numeric()->min(6),
            'gender_id' => RuleSet::create()->nullable()->string(),
            'about' => RuleSet::create()->nullable()->string(),
            'address' => RuleSet::create()->nullable()->string(),
            'home_county_id' => RuleSet::create()->nullable()->string(),
            'residence_county_id' => RuleSet::create()->nullable()->string(),
            'city' => RuleSet::create()->nullable()->string(),
            'state' => RuleSet::create()->nullable()->string(),
            'nationality' => RuleSet::create()->nullable()->string(),
            'kra_pin' => RuleSet::create()->nullable()->string(),
            'member_cv' => RuleSet::create()->nullable()->string(),
            'establishment' => RuleSet::create()->nullable()->string(),
            'title' => RuleSet::create()->nullable()->string(),
            'appointing_authority' => RuleSet::create()->nullable()->string(),
            'appointment_date' => RuleSet::create()->nullable()->string(),
            'appointment_letter' => RuleSet::create()->nullable()->string(),
            'appointment_end_date' => RuleSet::create()->nullable()->string(),
            'serving_term' => RuleSet::create()->nullable()->string(),
            'current_period' => RuleSet::create()->nullable()->string(),
            'user_id' => RuleSet::create()->required()->string(),
        ];
    }
}