<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateUsersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => Ruleset::create()->required()->email()->unique(User::class, 'email')->string(),
            'role' => RuleSet::create()->sometimes()->in(Role::allTypes()),
        ];
    }
}
