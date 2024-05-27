<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => RuleSet::create()
                ->sometimes()
                ->string(),
            'type' => RuleSet::create()
                ->sometimes()
                ->in(Role::allTypes())
                ->string(),
        ];
    }
}
