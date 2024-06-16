<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateMemberPositionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => RuleSet::create()->required()->string(),
            'position_id' => RuleSet::create()->required()->string(),
        ];
    }
}