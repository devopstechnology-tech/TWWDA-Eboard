<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateMemberRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => RuleSet::create()->required()->string(),
            'role' => RuleSet::create()->required()->string(),
        ];
    }
}
