<?php

declare(strict_types=1);

namespace App\Http\Requests;


use App\Models\Role;
use Sourcetoad\RuleHelper\RuleSet;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRolesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => RuleSet::create()->required()->string(),
            'email' => Ruleset::create()->sometimes()->email()->string(),
            'role' => RuleSet::create()->required()->string(),
        ];
    }
}