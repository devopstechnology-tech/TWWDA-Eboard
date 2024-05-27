<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here for update
            'logo' => RuleSet::create()->sometimes(),
            'textlogo' => RuleSet::create()->sometimes(),
            'name' => RuleSet::create()->sometimes()->string(),
            'about' => RuleSet::create()->sometimes()->string(),
            'website' => RuleSet::create()->sometimes()->string(),
            'iso' => RuleSet::create()->sometimes()->string(),
            'isologo' => RuleSet::create()->sometimes(),
            'address' => RuleSet::create()->sometimes()->string(),
            'county' => RuleSet::create()->sometimes()->string(),
            'city' => RuleSet::create()->sometimes()->string(),
            'state' => RuleSet::create()->sometimes()->string(),
            'phone1' => RuleSet::create()->sometimes(),
            'phone2' => RuleSet::create()->sometimes(),
            'pspdkitlicencekey' => RuleSet::create()->sometimes()->string(),
            'mailtype' => RuleSet::create()->sometimes(),
            // 'mailtype.id' => RuleSet::create()->required()->string(),
            // 'mailtype.name' => RuleSet::create()->required()->string(),
            // 'mailtype.values' => RuleSet::create()->required()->array(),
            // 'mailtype.values.*.nameField' => RuleSet::create()->required()->string(),
            // 'mailtype.values.*.namePlaceholder' => RuleSet::create()->required()->string(),
            // 'mailtype.values.*.valueName' => RuleSet::create()->nullable()->string(),
        ];
    }
}
