<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateCommitteeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => RuleSet::create()->required()->string(),
            'description' => RuleSet::create()->required()->string(),
            'icon' => RuleSet::create()->nullable()->file()->mimes('jpeg,jpg,png,gif,webp'),
            'cover' => RuleSet::create()->nullable()->file()->mimes('jpeg,jpg,png,gif,webp'),
        ];
    }
}
