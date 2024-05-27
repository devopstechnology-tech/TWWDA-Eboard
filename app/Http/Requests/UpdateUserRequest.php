<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first' => Ruleset::create()
                ->sometimes()
                ->string(),
            'last' => Ruleset::create()
                ->sometimes()
                ->string(),
            'email' => [
                Ruleset::create()
                    ->sometimes()
                    ->email()
                    ->unique(
                        User::class,
                        'email',
                        fn(Unique $rule) => $rule->ignore($this->email)
                    ),
                'email:rfc,dns', 'max:255',
            ],
            'phone' => RuleSet::create()
                ->sometimes()
                ->string()
                ->min(10)
                ->unique(
                    User::class,
                    'phone',
                    fn(Unique $rule) => $rule->ignore($this->phone)
                ),
            'id_number' => RuleSet::create()
                ->sometimes()
                ->string()
                ->min(5)
                ->unique(
                    User::class,
                    'id_number',
                    fn(Unique $rule) => $rule->ignore($this->id_number)
                ),
            'password' => RuleSet::create()
                ->sometimes()
                ->string()
                ->min(6),
            'status' => RuleSet::create()
                ->sometimes()
                ->boolean(),
            'type' => RuleSet::create()
                ->sometimes()
                ->in(User::allTypes()),
            'role' => RuleSet::create()
                ->sometimes()
                ->in(Role::allTypes()),
        ];
    }
}
