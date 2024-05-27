<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'folder_id' => Ruleset::create()->required()->string(),
            'name' => Ruleset::create()->required()->string(),
            'type' => Ruleset::create()->required()->string(),
            'fileupload' => Ruleset::create()->required(),
        ];
    }
}
