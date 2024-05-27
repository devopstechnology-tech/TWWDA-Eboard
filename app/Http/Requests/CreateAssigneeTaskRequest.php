<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateAssigneeTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
        ];
    }
}