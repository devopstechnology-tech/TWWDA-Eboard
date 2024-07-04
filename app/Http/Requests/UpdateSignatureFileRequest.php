<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateSignatureFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => Ruleset::create()->required()->string(),
            'name' => RuleSet::create()->required()->string(), // 400MB in kilobytes
            // 'ip' => RuleSet::create()->sometimes()->string(), // 400MB in kilobytes
            // 'location' => RuleSet::create()->sometimes()->string(), // 400MB in kilobytes
            'signatureupload' => RuleSet::create()->required()->file()->max(409600), // 400MB in kilobytes
        ];
    }
}
