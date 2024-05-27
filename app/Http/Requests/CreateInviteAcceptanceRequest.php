<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Users\Profile;
use Sourcetoad\RuleHelper\RuleSet;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class CreateInviteAcceptanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first' => Ruleset::create()->required()->string(),
            'last' => Ruleset::create()->required()->string(),
            'phone' => RuleSet::create()
                ->required()
                ->numeric()
                ->min(10)
                ->unique(
                    Profile::class,
                    'phone',
                    fn (Unique $rule) => $rule->ignore($this->phone)
                ),
            'id_number' => RuleSet::create()
                ->required()
                ->numeric()
                ->min(5)
                ->unique(
                    Profile::class,
                    'idpassportnumber',
                    fn (Unique $rule) => $rule->ignore($this->idpassportnumber)
                ),
            'password' => RuleSet::create()->required()->string()->min(6),
            'token' => RuleSet::create()->required()->string()->min(6),
        ];
    }
}