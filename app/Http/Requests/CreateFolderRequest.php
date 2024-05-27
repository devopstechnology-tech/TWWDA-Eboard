<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateFolderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
             'meeting_id' => Ruleset::create()->required()->string(),
             'name' => Ruleset::create()->required()->string(),
             'parent_id' => Ruleset::create()->required()->string(),
             'type' => Ruleset::create()->required()->string(),
            // Your rules here
        ];
    }
}
