<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Sourcetoad\RuleHelper\RuleSet;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first' => Ruleset::create()
                ->required()
                ->string(),
            'last' => Ruleset::create()
                ->required()
                ->string(),
            'email' => [
                Ruleset::create()
                    ->required()
                    ->email()
                    ->unique(
                        User::class,
                        'email'
                    ),
                'email:rfc,dns', 'max:255'],
            'phone' => RuleSet::create()
                ->required()
                ->string()
                ->minDigits(10)
                ->unique(
                    User::class,
                    'phone'
                ),
            'id_number' => RuleSet::create()
                ->required()
                ->string()
                ->min(5)
                ->unique(
                    User::class,
                    'id_number'
                ),
            'password' => Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => formatPhoneNumber($this->phone),
        ]);
    }
}
