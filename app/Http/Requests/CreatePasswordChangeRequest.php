<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Sourcetoad\RuleHelper\RuleSet;

class CreatePasswordChangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
            'otp' => RuleSet::create()
                ->required()
                ->string(),
        ];
    }
}
