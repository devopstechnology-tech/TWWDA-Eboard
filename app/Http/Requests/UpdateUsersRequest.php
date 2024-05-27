<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateUsersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => Ruleset::create()->sometimes()->email()->string(),
            'role' => RuleSet::create()->sometimes()->in(Role::allTypes()),
            'first' => Ruleset::create()->required()->string(),
            'last' => Ruleset::create()->required()->string(),
            'phone' => RuleSet::create()->required()->numeric()->min(10),
            'id_number' => RuleSet::create()->required()->numeric()->min(5),
            'password' => RuleSet::create()->nullable()->string()->min(6),
        ];
    }
}
