<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateModificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reason' => RuleSet::create()
                ->sometimes()
                ->string(),
            'action' => RuleSet::create()
                ->required()
                ->string()
                ->in(['approve', 'disapprove']),
        ];
    }
}
