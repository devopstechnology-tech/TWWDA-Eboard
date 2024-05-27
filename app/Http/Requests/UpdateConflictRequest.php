<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateConflictRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address'=>RuleSet::create()->required()->string(),
            'nature'=>RuleSet::create()->required()->string(),
            'amount'=>RuleSet::create()->required(),
            'ceased_date'=>RuleSet::create()->required()->string(),
            'remarks'=>RuleSet::create()->required()->string(),
            'conflict_id'=>RuleSet::create()->required()->string(),
        ];
    }
}
