<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateAlmanacRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => RuleSet::create()->required()->string(),
            'purpose' => RuleSet::create()->required()->string(),
            'start' => RuleSet::create()->required()->string(),
            'end' => RuleSet::create()->required()->string(),
            'budget' => RuleSet::create()->required(),
            'status' => RuleSet::create()->required()->string(),
            'held' => RuleSet::create()->required()->string(),
        ];
    }
}
