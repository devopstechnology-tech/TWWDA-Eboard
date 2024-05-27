<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here for update
            'id' => RuleSet::create()
                ->required()
                ->string(),
        ];
    }
}