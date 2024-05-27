<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreatePasswordResetRequest extends FormRequest
{
    public function rules($Class): array
    {
        return [
            'id_number' => RuleSet::create()
                ->required()
                ->exists(
                    $Class,
                    'id_number'
                )
                ->string(),
        ];
    }
}
