<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateCommitteeRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'description' => RuleSet::create()->required()->string(),
            'icon' => RuleSet::create()->nullable()->string(),
            // 'cover' => RuleSet::create()->nullable()->str'name' => RuleSet::create()->required()->string(),ing(),
            // 'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048'], // Example rules
        ];
    }
}
