<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => RuleSet::create()
                ->required()
                ->string(),
            'guard_name' => RuleSet::create()
                ->required()
                ->in(['web', 'api'])
                ->string(),
            'type' => RuleSet::create()
                ->required()
                ->in(Role::allTypes())
                ->string(),
        ];
    }
}
