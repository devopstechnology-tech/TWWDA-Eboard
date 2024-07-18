<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use App\Models\Users\Profile;
use Sourcetoad\RuleHelper\RuleSet;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class CreateUsersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => Ruleset::create()->required()->email()->unique(User::class, 'email')->string(),
            'role' => RuleSet::create()->sometimes()->in(Role::allTypes()),
            'first' => RuleSet::create()->required()->string(),
            'last' => RuleSet::create()->required()->string(),
            'phone' => RuleSet::create()->required()->min(10)
            ->unique(
                Profile::class,
                'phone',
                fn(Unique $rule) => $rule->ignore($this->phone)
            ),
            'id_number' => RuleSet::create()->required()->min(5)
            ->unique(
                Profile::class,
                'idpassportnumber',
                fn(Unique $rule) => $rule->ignore($this->id_number)
            ),
        ];
    }
}
